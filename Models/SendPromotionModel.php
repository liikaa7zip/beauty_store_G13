<?php
class SendPromotionModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getTelegramPromotionById($id)
    {
        $sql = "SELECT * FROM telegram_promotions WHERE id = ?";
        $stmt = $this->db->query($sql, [$id]);
        return $stmt->fetch();
    }

    public function getTelegramPromotionByPhone($phone)
    {
        $sql = "SELECT * FROM telegram_promotions WHERE phone_number = ?";
        $stmt = $this->db->query($sql, [$phone]);
        return $stmt->fetch();
    }

    public function updateTelegramChatId($phone, $chatId)
    {
        $sql = "UPDATE telegram_promotions SET telegram_chat_id = ? WHERE phone_number = ?";
        $stmt = $this->db->query($sql, [$chatId, $phone]);
        return $stmt->rowCount() > 0;
    }
}
?>