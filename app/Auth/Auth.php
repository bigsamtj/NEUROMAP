<?php

namespace App\Auth;

use App\Database;
use PDO;

class Auth
{
    public static function login(string $username, string $password): bool
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password_hash'])) {
            Session::regenerate();
            Session::set('user_id', $user['id']);
            Session::set('username', $user['username']);
            return true;
        }

        return false;
    }

    public static function check(): bool
    {
        return Session::get('user_id') !== null;
    }

    public static function logout(): void
    {
        Session::destroy();
    }
}
