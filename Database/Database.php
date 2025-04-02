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
                $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    function query($sql, $params = [])
{
    $stmt = $this->pdo->prepare($sql);
    if (!$stmt->execute($params)) {
        // If the execution fails, throw an exception with the error information
        $errorInfo = $stmt->errorInfo();
        throw new Exception("Database query failed: " . $errorInfo[2]);
    }
    return $stmt;
}


    function prepare($sql)
    {
        return $this->pdo->prepare($sql);
    }
    function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }
}
?>