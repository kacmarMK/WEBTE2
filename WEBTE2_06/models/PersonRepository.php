<?php

require_once __DIR__ . "/Person.php";

class PersonRepository{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function insertPerson($name, $day, $month){
        $qD = "SELECT id FROM days WHERE day=? AND month=?";
        $stmt = $this->conn->prepare($qD);
        $stmt->bindParam(1, $day, PDO::PARAM_INT);
        $stmt->bindParam(2, $month, PDO::PARAM_INT);
        $stmt->execute();
        $dayID = $stmt->fetchAll();

        $qI = "INSERT INTO records (day_id, country_id, type, value) VALUES (?, 4, 'name', ?)";
        $stm = $this->conn->prepare($qI);
        $stm->bindParam(1, $dayID[0]['id'], PDO::PARAM_INT);
        $stm->bindParam(2, $name, PDO::PARAM_STR);
        $stm->execute();
    }

    public function getAll(){
        $sql = "SELECT * FROM records";
        $stm = $this->conn->query($sql);
        return  $stm->fetchAll(PDO::FETCH_CLASS, "Person");
    }

    public function getById($id){
        $sql = "SELECT * FROM records WHERE id=?";
        $stm = $this->conn->prepare($sql);
        $stm->bindParam(1, $id, PDO::PARAM_INT);
        $stm->execute();
        return  $stm->fetchAll(PDO::FETCH_CLASS, "Person");
    }

    public function getPersonsByDate($day, $month, $country){
        $sql = "SELECT id,  value FROM records WHERE day_id=(SELECT id FROM days WHERE day=? and month=?) AND type='name' AND country_id=(SELECT id FROM countries WHERE title=?)";
        $stm = $this->conn->prepare($sql);
        $stm->bindParam(1, $day, PDO::PARAM_INT);
        $stm->bindParam(2, $month, PDO::PARAM_INT);
        $stm->bindParam(3, $country, PDO::PARAM_STR);
        $stm->execute();
        return  $stm->fetchAll(PDO::FETCH_CLASS, "Person");
    }

    public function getDateByNameCountry($name, $country){
        $sql = "SELECT * FROM days 
                WHERE days.id IN (SELECT day_id FROM records 
                        WHERE records.type='name' AND records.value=? AND records.country_id=(SELECT id FROM countries WHERE title=?))";
                                

        $stm = $this->conn->prepare($sql);
        $stm->bindParam(1, $name, PDO::PARAM_STR);
        $stm->bindParam(2, $country, PDO::PARAM_STR);
        $stm->execute();
        
        return $stm->fetchAll(PDO::FETCH_CLASS, "Person");
    }
}
?>