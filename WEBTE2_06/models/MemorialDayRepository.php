<?php

require_once __DIR__ . "/MemorialDay.php";

class MemorialDayRepository{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll(){
        $sql = "SELECT records.id, days.day, days.month, records.value FROM records, days WHERE records.type='memorial day' AND records.day_id=days.id";
        $stm = $this->conn->query($sql);
        return  $stm->fetchAll(PDO::FETCH_CLASS, "MemorialDay");
    }
}
?>