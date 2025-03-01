<?php
class Database
{
    private $pdo;
    function __construct()
    {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname= "beauty_store_data";

        try {
           $this->pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
    function query($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
}

    


