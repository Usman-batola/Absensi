<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\LokasiModel;
use App\Models\LokasiUserModel;
use App\Models\AbsensiModel;

class Admin extends BaseController
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

    private function checkAdminLogin()
    {
        if (!session()->has('isLoggedIn') || session()->get('user_role') !== 'admin') {
            return redirect()->to('/auth/login');
        }
    }

    public function dashboard()
    {
        if ($redirect = $this->checkAdminLogin()) return $redirect;

        $totalUsers = $this->userModel->where('role', 'user')->countAllResults();
        $totalLokasi = $this->lokasiModel->countAllResults();
        $totalAbsensi = $this->absensiModel->countAllResults();

        $data = [
            'title' => 'Admin Dashboard',
            'totalUsers' => $totalUsers,
            'totalLokasi' => $totalLokasi,
            'totalAbsensi' => $totalAbsensi
        ];

        return view('admin/dashboard', $data);
    }

    public function users()
    {
        if ($redirect = $this->checkAdminLogin()) return $redirect;

        $users = $this->userModel->select('users.*, lokasi.name as lokasi_name')
                                ->join('lokasi_user', 'lokasi_user.user_id = users.id', 'left')
                                ->join('lokasi', 'lokasi.id = lokasi_user.lokasi_id', 'left')
                                ->where('role', 'user')
                                ->findAll();

        $data = [
            'title' => 'Manage Users',
            'users' => $users
        ];

        return view('admin/users', $data);
    }

    public function addUser()
    {
        if ($redirect = $this->checkAdminLogin()) return $redirect;

        if ($this->request->is('post')) {
            $this->userModel->save([
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'role' => 'user'
            ]);

            $userId = $this->userModel->getInsertID();
            $lokasiId = $this->request->getPost('lokasi_id');

            if ($lokasiId) {
                $this->lokasiUserModel->insert([
                    'user_id' => $userId,
                    'lokasi_id' => $lokasiId
                ]);
            }

            session()->setFlashdata('success', 'User berhasil ditambahkan');
            return redirect()->to('/admin/users');
        }

        $lokasi = $this->lokasiModel->findAll();

        $data = [
            'title' => 'Tambah User',
            'lokasi' => $lokasi
        ];

        return view('admin/add_user', $data);
    }

    public function editUser($id)
    {
        if ($redirect = $this->checkAdminLogin()) return $redirect;

        $user = $this->userModel->find($id);

        if (!$user) {
            throw new \Exception('User tidak ditemukan');
        }

        if ($this->request->is('post')) {
            $data = [
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
            ];

            if ($this->request->getPost('password')) {
                $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
            }

            $this->userModel->update($id, $data);

            // Handle lokasi assignment
            $lokasiId = $this->request->getPost('lokasi_id');
            $existingLokasi = $this->lokasiUserModel->where('user_id', $id)->first();

            if ($existingLokasi) {
                $this->lokasiUserModel->where('id', $existingLokasi['id'])
                                     ->set(['lokasi_id' => $lokasiId])
                                     ->update();
            } else {
                $this->lokasiUserModel->insert([
                    'user_id' => $id,
                    'lokasi_id' => $lokasiId
                ]);
            }

            session()->setFlashdata('success', 'User berhasil diupdate');
            return redirect()->to('/admin/users');
        }

        $lokasi = $this->lokasiModel->findAll();
        $userLokasi = $this->lokasiUserModel->where('user_id', $id)->first();

        $data = [
            'title' => 'Edit User',
            'user' => $user,
            'lokasi' => $lokasi,
            'userLokasi' => $userLokasi
        ];

        return view('admin/edit_user', $data);
    }

    public function deleteUser($id)
    {
        if ($redirect = $this->checkAdminLogin()) return $redirect;

        $this->userModel->delete($id);
        $this->lokasiUserModel->where('user_id', $id)->delete();

        session()->setFlashdata('success', 'User berhasil dihapus');
        return redirect()->to('/admin/users');
    }

    public function lokasi()
    {
        if ($redirect = $this->checkAdminLogin()) return $redirect;

        $lokasi = $this->lokasiModel->findAll();

        $data = [
            'title' => 'Manage Lokasi',
            'lokasi' => $lokasi
        ];

        return view('admin/lokasi', $data);
    }

    public function addLokasi()
    {
        if ($redirect = $this->checkAdminLogin()) return $redirect;

        if ($this->request->is('post')) {
            $this->lokasiModel->save([
                'name' => $this->request->getPost('name'),
                'latitude' => $this->request->getPost('latitude'),
                'longitude' => $this->request->getPost('longitude'),
                'radius' => $this->request->getPost('radius')
            ]);

            session()->setFlashdata('success', 'Lokasi berhasil ditambahkan');
            return redirect()->to('/admin/lokasi');
        }

        return view('admin/add_lokasi');
    }

    public function editLokasi($id)
    {
        if ($redirect = $this->checkAdminLogin()) return $redirect;

        $lokasi = $this->lokasiModel->find($id);

        if (!$lokasi) {
            throw new \Exception('Lokasi tidak ditemukan');
        }

        if ($this->request->is('post')) {
            $this->lokasiModel->update($id, [
                'name' => $this->request->getPost('name'),
                'latitude' => $this->request->getPost('latitude'),
                'longitude' => $this->request->getPost('longitude'),
                'radius' => $this->request->getPost('radius')
            ]);

            session()->setFlashdata('success', 'Lokasi berhasil diupdate');
            return redirect()->to('/admin/lokasi');
        }

        $data = [
            'title' => 'Edit Lokasi',
            'lokasi' => $lokasi
        ];

        return view('admin/edit_lokasi', $data);
    }

    public function deleteLokasi($id)
    {
        if ($redirect = $this->checkAdminLogin()) return $redirect;

        $this->lokasiModel->delete($id);

        session()->setFlashdata('success', 'Lokasi berhasil dihapus');
        return redirect()->to('/admin/lokasi');
    }

    public function absensi()
    {
        if ($redirect = $this->checkAdminLogin()) return $redirect;

        $page = $this->request->getGet('page') ?? 1;
        $search = $this->request->getGet('search');

        if ($search) {
            $absensi = $this->absensiModel->searchAbsensi($search, $page);
        } else {
            $absensi = $this->absensiModel->getAllAbsensi($page);
        }

        $data = [
            'title' => 'Manage Absensi',
            'absensi' => $absensi,
            'search' => $search
        ];

        return view('admin/absensi', $data);
    }

    public function deleteAbsensi($id)
    {
        if ($redirect = $this->checkAdminLogin()) return $redirect;

        $this->absensiModel->delete($id);

        session()->setFlashdata('success', 'Data absensi berhasil dihapus');
        return redirect()->to('/admin/absensi');
    }
}
