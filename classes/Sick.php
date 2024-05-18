<?php

include_once(__DIR__ . '/Db.php');

class Sick
{
    private $user_id;
    private $start_date;
    private $end_date;

    public function save()
    {
        $conn = Db::getConnection();
        $sql = "INSERT INTO sick (userId, start_date, end_date) VALUES (:user_id, :start_date, :end_date)";
        $statement = $conn->prepare($sql);
        $statement->bindValue(':user_id', $this->user_id);
        $statement->bindValue(':start_date', $this->start_date);
        $statement->bindValue(':end_date', $this->end_date);
        $result = $statement->execute();
        return $result;
    }

    //getters and setters

    public function getUserId()
    {
        return $this->user_id;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    public function getStartDate()
    {
        return $this->start_date;
    }


    public function setStartDate($start_date)
    {
        $this->start_date = $start_date;
    }

    public function getEndDate()
    {
        return $this->end_date;
    }

    public function setEndDate($end_date)
    {
        $this->end_date = $end_date;
    }

    public static function getAllData()
    {
        $conn = Db::getConnection();
        $statement = $conn->query("SELECT * FROM sick");
        return $statement->fetchAll();
    }

    public static function getOneData($userId)
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT * FROM sick WHERE userId = :userId");
        $statement->bindValue(':userId', $userId);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC); // Fetch all sick days as an associative array
        return $result; // Return the array of sick days
    }
}
