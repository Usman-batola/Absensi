<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\LokasiModel;
use App\Models\LokasiUserModel;
use App\Models\AbsensiModel;

class User extends BaseController
{
    protected $userModel;
    protected $lokasiModel;
    protected $lokasiUserModel;
    protected $absensiModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->lokasiModel = new LokasiModel();
        $this->lokasiUserModel = new LokasiUserModel();
        $this->absensiModel = new AbsensiModel();
    }

    private function checkLogin()
    {
        if (!session()->has('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }
    }

    public function dashboard()
    {
        if (!session()->has('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $userId = session()->get('user_id');
        $lokasi = $this->lokasiUserModel->getLokasiForUser($userId);
        $todayAbsensi = $this->absensiModel->getTodayAbsensi($userId);
        $allAbsensi = $this->absensiModel->getAbsensiByUser($userId);

        $data = [
            'title' => 'Dashboard',
            'lokasi' => $lokasi,
            'todayAbsensi' => $todayAbsensi,
            'allAbsensi' => $allAbsensi
        ];

        return view('user/dashboard', $data);
    }

    public function checkLocation()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['error' => 'Invalid request']);
        }

        $userId = session()->get('user_id');
        $userLat = $this->request->getPost('latitude');
        $userLon = $this->request->getPost('longitude');

        $lokasi = $this->lokasiUserModel->getLokasiForUser($userId);

        if (!$lokasi) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Lokasi belum ditentukan untuk user ini'
            ]);
        }

        $lokasiData = $this->lokasiModel->find($lokasi['lokasi_id']);

        // Hitung jarak menggunakan Haversine formula
        $distance = $this->calculateDistance(
            $userLat, $userLon,
            $lokasiData['latitude'], $lokasiData['longitude']
        );

        if ($distance <= $lokasiData['radius']) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Anda berada di lokasi yang tepat',
                'distance' => round($distance, 2)
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Anda tidak berada di lokasi yang ditentukan',
                'distance' => round($distance, 2),
                'requiredRadius' => $lokasiData['radius']
            ]);
        }
    }

    public function saveAbsensi()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['error' => 'Invalid request']);
        }

        $userId = session()->get('user_id');
        $type = $this->request->getPost('type'); // datang or pulang
        $latitude = $this->request->getPost('latitude');
        $longitude = $this->request->getPost('longitude');
        $accuracy = $this->request->getPost('accuracy');
        $photo = $this->request->getFile('photo');

        // Proteksi Fake GPS Sederhana: Cek Akurasi
        if ($accuracy && $accuracy > 100) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Akurasi lokasi terlalu rendah (' . round($accuracy) . 'm). Pastikan Anda berada di ruang terbuka dan tidak menggunakan Fake GPS.'
            ]);
        }

        $lokasi = $this->lokasiUserModel->getLokasiForUser($userId);
        $tanggal = date('Y-m-d');

        // Get or create today's absensi record
        $absensi = $this->absensiModel->where('user_id', $userId)
                                       ->where('tanggal', $tanggal)
                                       ->first();

        if (!$absensi) {
            $this->absensiModel->save([
                'user_id' => $userId,
                'lokasi_id' => $lokasi['lokasi_id'],
                'tanggal' => $tanggal
            ]);
            $absensi = $this->absensiModel->where('user_id', $userId)
                                           ->where('tanggal', $tanggal)
                                           ->first();
        }

        $photoName = null;
        if ($photo && $photo->isValid() && !$photo->hasMoved()) {
            $photoName = $photo->getRandomName();
            $photo->move('uploads/absensi', $photoName);
        }

        $updateData = [];
        if ($type === 'datang') {
            $updateData['jam_datang'] = date('H:i:s');
            $updateData['foto_datang'] = $photoName;
            $updateData['latitude_datang'] = $latitude;
            $updateData['longitude_datang'] = $longitude;
        } else if ($type === 'pulang') {
            $updateData['jam_pulang'] = date('H:i:s');
            $updateData['foto_pulang'] = $photoName;
            $updateData['latitude_pulang'] = $latitude;
            $updateData['longitude_pulang'] = $longitude;
        }

        $this->absensiModel->update($absensi['id'], $updateData);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Absensi ' . $type . ' berhasil disimpan'
        ]);
    }

    public function history()
    {
        if (!session()->has('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $userId = session()->get('user_id');
        $allAbsensi = $this->absensiModel->getAbsensiByUser($userId);

        $data = [
            'title' => 'History Absensi',
            'allAbsensi' => $allAbsensi
        ];

        return view('user/history', $data);
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // Radius of the earth in meters

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earthRadius * $c;

        return $distance;
    }
}
