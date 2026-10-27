<?php

namespace App\Core;

class Helper
{
    /**
     * Load configuration
     */
    public static function config(string $key = null, $default = null)
    {
        static $config = null;

        if ($config === null) {
            $config = require __DIR__ . '/../../config/app.php';
        }

        if ($key === null) {
            return $config;
        }

        $keys = explode('.', $key);
        $value = $config;

        foreach ($keys as $k) {
            if (!isset($value[$k])) {
                return $default;
            }
            $value = $value[$k];
        }

        return $value;
    }

    /**
     * Redirect helper
     */
    public static function redirect(string $url): void
    {
        header("Location: " . $url);
        exit;
    }

    /**
     * Check if user is logged in
     */
    public static function isLoggedIn(): bool
    {
        return isset($_SESSION['neuromap_user']);
    }

    /**
     * Require authentication
     */
    public static function requireAuth(): void
    {
        if (!self::isLoggedIn()) {
            self::redirect('/login');
        }
    }

    /**
     * Sanitize string
     */
    public static function clean(?string $value): string
    {
        return htmlspecialchars(trim($value ?? ''), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Generate a random string
     */
    public static function randomString(int $length = 16): string
    {
        return bin2hex(random_bytes($length / 2));
    }

    /**
     * JSON response
     */
    public static function json(array $data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    /**
     * Dump and die (for debugging)
     */
    public static function dd(...$vars): void
    {
        echo '<pre>';
        foreach ($vars as $var) {
            print_r($var);
            echo "\n";
        }
        echo '</pre>';
        die();
    }
}
