<?php
include_once(__DIR__ . '/Db.php');
<<<<<<< HEAD
class Task{

    public static function getTaskById($id){
=======
class Task
{

    public static function getTaskById($id)
    {
>>>>>>> 1b71aaafc9125ee132aefef79598b8f4fcfb0e50
        $conn = Db::getConnection();
        $sql = "SELECT * FROM task WHERE id = :id";
        $statement = $conn->prepare($sql);
        $statement->bindParam(':id', $id);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
<<<<<<< HEAD
=======

    public static function getAllTasks()
    {
        $conn = Db::getConnection();
        $sql = "SELECT * FROM task";
        $statement = $conn->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function createTask($userId, $taskId, $date, $start_time, $end_time)
    {
        $conn = Db::getConnection();
        $sql = "INSERT INTO user_task (userId, taskId, date, start_time, end_time) VALUES (:userId, :taskId, :date, :start_time, :end_time)";
        $statement = $conn->prepare($sql);
        $statement->bindParam(':userId', $userId);
        $statement->bindParam(':taskId', $taskId);
        $statement->bindParam(':date', $date);
        $statement->bindParam(':start_time', $start_time);
        $statement->bindParam(':end_time', $end_time);
        if ($start_time < $end_time) {
            $result = $statement->execute();
            return $result;
        } else {
            throw new Exception('end time must be greater than start time');
            return false;
        }
    }
>>>>>>> 1b71aaafc9125ee132aefef79598b8f4fcfb0e50
}
