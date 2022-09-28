<?php

require_once __DIR__ . "/Holiday.php";

class HolidayRepository{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll($code){
        $sql = "SELECT records.id, days.day, days.month, records.value FROM days, records WHERE records.type='holiday' AND records.country_id=(SELECT id FROM countries WHERE countries.code=?) AND records.day_id=days.id";
        $stm = $this->conn->prepare($sql);
        $stm->bindParam(1, $code, PDO::PARAM_STR);
        $stm->execute();
        return  $stm->fetchAll(PDO::FETCH_CLASS, "Holiday");
    }
}
?>