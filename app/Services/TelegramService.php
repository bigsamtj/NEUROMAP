<?php

namespace App\Services;

class TelegramService
{
    private string $token;
    private string $chatId;
    private bool $enabled;

    public function __construct()
    {
        $config = require __DIR__ . '/../../config/app.php';

        $this->enabled = $config['telegram']['enabled'] ?? false;
        $this->token   = $config['telegram']['bot_token'] ?? '';
        $this->chatId  = $config['telegram']['chat_id'] ?? '';
    }

    /**
     * Send a text message
     */
    public function sendMessage(string $text, string $parseMode = 'HTML'): bool
    {
        if (!$this->enabled || empty($this->token) || empty($this->chatId)) {
            return false;
        }

        $url = "https://api.telegram.org/bot{$this->token}/sendMessage";

        $data = [
            'chat_id'    => $this->chatId,
            'text'       => $text,
            'parse_mode' => $parseMode,
            'disable_web_page_preview' => true
        ];

        return $this->request($url, $data);
    }

    /**
     * Send a document (file)
     */
    public function sendDocument(string $filePath, string $caption = ''): bool
    {
        if (!$this->enabled || empty($this->token) || empty($this->chatId)) {
            return false;
        }

        if (!file_exists($filePath)) {
            return false;
        }

        $url = "https://api.telegram.org/bot{$this->token}/sendDocument";

        $post = [
            'chat_id'  => $this->chatId,
            'caption'  => $caption,
            'document' => new \CURLFile($filePath)
        ];

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $post,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 30
        ]);

        $response = curl_exec($ch);
        $error    = curl_error($ch);
        curl_close($ch);

        return empty($error);
    }

    private function request(string $url, array $data): bool
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => http_build_query($data),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 15
        ]);

        $response = curl_exec($ch);
        $error    = curl_error($ch);
        curl_close($ch);

        return empty($error);
    }
}
