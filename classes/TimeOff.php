<?php

include_once(__DIR__ . '/Db.php');

class TimeOff
{
    private $user_id;
    private $start_date;
    private $end_date;
    private $reason;
    private $day_type;

    public function save()
    {
        $conn = Db::getConnection();
        $sql = "INSERT INTO time_off (userId, start_time, end_time, reason, day_type) VALUES (:user_id, :start_date, :end_date, :reason, :day_type)";
        $statement = $conn->prepare($sql);
        $statement->bindValue(':user_id', $this->user_id);
        $statement->bindValue(':start_date', $this->start_date);
        $statement->bindValue(':end_date', $this->end_date);
        $statement->bindValue(':reason', $this->reason);
        $statement->bindValue(':day_type', $this->day_type);
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

    public function getReason()
    {
        return $this->reason;
    }

    public function setReason($reason)
    {
        $this->reason = $reason;
    }

    public static function getAllTimeOffRequests($userid)
    {
        $conn = Db::getConnection();
        $sql = "SELECT * FROM time_off where userId = :user_Id";
        $statement = $conn->prepare($sql);
        $statement->bindParam(':user_Id', $userid);
        $statement->execute(); // Voer de query uit
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function getAllTimeOffRequestsAllUsers()
    {
        $conn = Db::getConnection();
        $sql = "SELECT * FROM time_off";
        $statement = $conn->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function acceptTimeOffRequest($timeOffId)
    {
        $conn = Db::getConnection();
        $sql = "UPDATE time_off SET status = 'Accepted' WHERE id = :timeOffId";
        $statement = $conn->prepare($sql);
        $statement->bindValue(':timeOffId', $timeOffId);
        $result = $statement->execute();
        return $result;
    }

    public function declineTimeOffRequest($timeOffId)
    {
        $conn = Db::getConnection();
        $sql = "UPDATE time_off SET status = 'Declined' WHERE id = :timeOffId";
        $statement = $conn->prepare($sql);
        $statement->bindValue(':timeOffId', $timeOffId);
        $result = $statement->execute();
        return $result;
    }




    /** 
     * Get the value of day_type
     */
    public function getDay_type()
    {
        return $this->day_type;
    }

    /**
     * Set the value of day_type
     *
     * @return  self
     */
    public function setDay_type($day_type)
    {
        $this->day_type = $day_type;

        return $this;
    }
}
