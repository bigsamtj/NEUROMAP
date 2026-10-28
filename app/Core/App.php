<?php

namespace App\Core;

class App
{
    public static function init(): void
    {
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

    /**
     * Render a view (optionally inside the main layout)
     */
    public static function view(string $name, array $data = [], bool $useLayout = true): void
    {
        extract($data);

        $viewPath = __DIR__ . '/../../resources/views/' . $name . '.php';

        if (!file_exists($viewPath)) {
            echo "View [{$name}] not found.";
            return;
        }

        // If layout is disabled (e.g. login page), render directly
        if (!$useLayout) {
            require $viewPath;
            return;
        }

        // Capture the view content
        ob_start();
        require $viewPath;
        $content = ob_get_clean();

        // Make title available to layout
        $title = $title ?? 'NEUROMAP';

        // Render layout with content
        require __DIR__ . '/../../resources/views/layout.php';
    }

    public static function basePath(string $path = ''): string
    {
        return dirname(__DIR__, 2) . ($path ? '/' . ltrim($path, '/') : '');
    }
}
