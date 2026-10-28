<?php

namespace App\Controllers;

use App\Core\Helper;
use App\Core\App;

class AuthController
{
    public function showLogin(): void
    {
        // If already logged in, go to dashboard
        if (Helper::isLoggedIn()) {
            Helper::redirect('/dashboard');
        }

        App::view('login');
    }

    public function login(): void
    {
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        $config = Helper::config('admin');

        if ($username === $config['username'] && $password === $config['password']) {
            $_SESSION['neuromap_user'] = [
                'username' => $username,
                'logged_in_at' => date('Y-m-d H:i:s')
            ];

            Helper::redirect('/dashboard');
        }

        // Failed login
        App::view('login', [
            'error' => 'Invalid username or password'
        ]);
    }

    public function logout(): void
    {
        unset($_SESSION['neuromap_user']);
        session_destroy();
        Helper::redirect('/login');
    }
}
