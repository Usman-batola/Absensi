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
        $this->checkAdminLogin();

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
        $this->checkAdminLogin();

        $users = $this->userModel->where('role', 'user')->findAll();

        $data = [
            'title' => 'Manage Users',
            'users' => $users
        ];

        return view('admin/users', $data);
    }

    public function addUser()
    {
        $this->checkAdminLogin();

        if ($this->request->getMethod() === 'post') {
            $this->userModel->save([
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'role' => 'user'
            ]);

            session()->setFlashdata('success', 'User berhasil ditambahkan');
            return redirect()->to('/admin/users');
        }

        return view('admin/add_user');
    }

    public function editUser($id)
    {
        $this->checkAdminLogin();

        $user = $this->userModel->find($id);

        if (!$user) {
            throw new \Exception('User tidak ditemukan');
        }

        if ($this->request->getMethod() === 'post') {
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
                $this->lokasiUserModel->update($existingLokasi['id'], ['lokasi_id' => $lokasiId]);
            } else {
                $this->lokasiUserModel->save(['user_id' => $id, 'lokasi_id' => $lokasiId]);
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
        $this->checkAdminLogin();

        $this->userModel->delete($id);
        $this->lokasiUserModel->where('user_id', $id)->delete();

        session()->setFlashdata('success', 'User berhasil dihapus');
        return redirect()->to('/admin/users');
    }

    public function lokasi()
    {
        $this->checkAdminLogin();

        $lokasi = $this->lokasiModel->findAll();

        $data = [
            'title' => 'Manage Lokasi',
            'lokasi' => $lokasi
        ];

        return view('admin/lokasi', $data);
    }

    public function addLokasi()
    {
        $this->checkAdminLogin();

        if ($this->request->getMethod() === 'post') {
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
        $this->checkAdminLogin();

        $lokasi = $this->lokasiModel->find($id);

        if (!$lokasi) {
            throw new \Exception('Lokasi tidak ditemukan');
        }

        if ($this->request->getMethod() === 'post') {
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
        $this->checkAdminLogin();

        $this->lokasiModel->delete($id);

        session()->setFlashdata('success', 'Lokasi berhasil dihapus');
        return redirect()->to('/admin/lokasi');
    }

    public function absensi()
    {
        $this->checkAdminLogin();

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
}
