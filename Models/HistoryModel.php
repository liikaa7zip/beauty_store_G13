<?php
require_once "Database/Database.php";

class HistoryModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

   
}
