<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        if (session()->has('isLoggedIn')) {
            if (session()->get('user_role') === 'admin') {
                return redirect()->to('/admin/dashboard');
            } else {
                return redirect()->to('/user/dashboard');
            }
        }

        return redirect()->to('/auth/login');
    }
}
