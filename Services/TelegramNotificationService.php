<?php
class TelegramNotificationService {
    private $botToken;
    private $chatId;

    public function __construct($botToken, $chatId) {
        $this->botToken = $botToken;
        $this->chatId = $chatId;
    }

   public function sendMessage($message) {
    try {
        $url = "https://api.telegram.org/bot{$this->botToken}/sendMessage";
        
        $data = [
            'chat_id' => $this->chatId,
            'text' => $message,
            'parse_mode' => 'HTML'
        ];

        $options = [
            'http' => [
                'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data)
            ]
        ];

        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        if ($result === false) {
            error_log("Failed to send Telegram message");
            return false;
        }

        $response = json_decode($result, true);
        if (!$response['ok']) {
            error_log("Telegram API error: " . print_r($response, true));
            return false;
        }

        return true;
    } catch (Exception $e) {
        error_log("Telegram notification error: " . $e->getMessage());
        return false;
    }
}

}
