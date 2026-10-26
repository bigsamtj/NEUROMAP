<?php

namespace App\Services;

class TelegramService
{
    private string $botToken;
    private string $chatId;

    public function __construct()
    {
        // Muat konfigurasi dari config/app.php
        $config = require __DIR__ . '/../../config/app.php';
        
        $this->botToken = $config['telegram']['bot_token'] ?? '';
        $this->chatId = $config['telegram']['chat_id'] ?? '';
    }

    public function sendReport(string $message): bool
    {
        if (empty($this->botToken) || empty($this->chatId)) {
            return false;
        }

        $url = "https://api.telegram.org/bot{$this->botToken}/sendMessage";
        
        $data = [
            'chat_id' => $this->chatId,
            'text' => $message,
            'parse_mode' => 'Markdown'
        ];

        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data),
                'timeout' => 5
            ]
        ];

        $context = stream_context_create($options);
        $result = @file_get_contents($url, false, $context);

        return $result !== false;
    }
}
