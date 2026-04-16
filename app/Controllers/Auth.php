<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function login()
    {
        if ($this->request->getMethod() === 'post') {
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            $user = $this->userModel->getUserByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                session()->set([
                    'user_id'   => $user['id'],
                    'user_name' => $user['name'],
                    'user_email' => $user['email'],
                    'user_role' => $user['role'],
                    'isLoggedIn' => true
                ]);

                if ($user['role'] === 'admin') {
                    return redirect()->to('/admin/dashboard');
                } else {
                    return redirect()->to('/user/dashboard');
                }
            } else {
                session()->setFlashdata('error', 'Email atau password salah');
                return redirect()->back();
            }
        }

        return view('auth/login');
    }

    public function register()
    {
        if ($this->request->getMethod() === 'post') {
            $name = $this->request->getPost('name');
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');
            $confirmPassword = $this->request->getPost('confirm_password');

            if ($password !== $confirmPassword) {
                session()->setFlashdata('error', 'Password tidak cocok');
                return redirect()->back();
            }

            $existingUser = $this->userModel->getUserByEmail($email);
            if ($existingUser) {
                session()->setFlashdata('error', 'Email sudah terdaftar');
                return redirect()->back();
            }

            $this->userModel->save([
                'name' => $name,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'role' => 'user'
            ]);

            session()->setFlashdata('success', 'Registrasi berhasil! Silakan login');
            return redirect()->to('/auth/login');
        }

        return view('auth/register');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth/login');
    }
}
