<?php
class ClockTime
{
    public static function clockIn($userId)
    {
        $conn = Db::getConnection();
        $sql = "INSERT INTO clock_times (user_id, clock_in_time) VALUES (:user_id, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
    }

    public static function clockOut($userId)
    {
        $conn = Db::getConnection();
        $sql = "UPDATE clock_times SET clock_out_time = NOW() WHERE user_id = :user_id AND clock_out_time IS NULL";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
    }

    public static function getClockTimeData($userId)
    {
        $conn = Db::getConnection();
        $sql = "SELECT * FROM clock_times WHERE user_id = :user_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetchAll();
    }

}