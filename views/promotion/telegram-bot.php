<?php

class TelegramBot
{
    private $apiUrl;

    public function __construct()
    {
        $botToken = '7761819194:AAH5eZjz6w_7OusezDLCpFMyCi2sXhMP5Tg'; 
        $this->apiUrl = "https://api.telegram.org/bot$botToken/";
    }

    public function sendMessage($chatId, $message)
    {
        $data = [
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'Markdown'
        ];

        $this->makeRequest('sendMessage', $data);
    }

    private function makeRequest($method, $data)
    {
        $url = $this->apiUrl . $method;
        $options = [
            'http' => [
                'header'  => "Content-Type: application/json\r\n",
                'method'  => 'POST',
                'content' => json_encode($data),
            ],
        ];
        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);

        if ($response === false) {
            error_log("Failed to send request to Telegram API: $url");
        } else {
            error_log("Telegram API response: $response");
        }
    }
}
