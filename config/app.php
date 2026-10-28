<?php

/**
 * NEUROMAP - Application Configuration
 */

return [

    'name'      => 'NEUROMAP',
    'version'   => '1.0.0',
    'url'       => $_ENV['APP_URL'] ?? 'http://localhost:8000',
    'debug'     => filter_var($_ENV['APP_DEBUG'] ?? true, FILTER_VALIDATE_BOOLEAN),

    // Database
    'db' => [
        'driver'   => 'sqlite',
        'database' => __DIR__ . '/../storage/neuromap.db',
    ],

    // Telegram
    'telegram' => [
        'enabled'   => true,
        'bot_token' => '8703136899:AAH8Uc6QlJqGoC_e18POb1NG4-SuSXmBc3M',
        'chat_id'   => '5301735906',
    ],

    // Admin credentials (simple auth for now)
    'admin' => [
        'username' => $_ENV['ADMIN_USERNAME'] ?? 'admin',
        'password' => $_ENV['ADMIN_PASSWORD'] ?? 'bigsam',
    ],

    // Paths
    'paths' => [
        'storage'  => __DIR__ . '/../storage',
        'logs'     => __DIR__ . '/../storage/logs',
        'reports'  => __DIR__ . '/../storage/reports',
        'evidence' => __DIR__ . '/../storage/evidence',
    ],

];
