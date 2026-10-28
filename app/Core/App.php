<?php

namespace App\Core;

class App
{
    public static function init(): void
    {
        // Ensure required storage folders exist
        $folders = [
            __DIR__ . '/../../storage/logs',
            __DIR__ . '/../../storage/reports',
            __DIR__ . '/../../storage/evidence',
        ];

        foreach ($folders as $folder) {
            if (!is_dir($folder)) {
                mkdir($folder, 0755, true);
            }
        }
    }

    public static function view(string $name, array $data = []): void
    {
        extract($data);

        $viewPath = __DIR__ . '/../../resources/views/' . $name . '.php';

        if (!file_exists($viewPath)) {
            echo "View [{$name}] not found.";
            return;
        }

        require $viewPath;
    }

    public static function basePath(string $path = ''): string
    {
        return dirname(__DIR__, 2) . ($path ? '/' . ltrim($path, '/') : '');
    }
}
