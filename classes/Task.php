<?php
include_once(__DIR__ . '/Db.php');
class Task
{

    public static function getTaskById($id)
    {
        $conn = Db::getConnection();
        $sql = "SELECT * FROM task WHERE id = :id";
        $statement = $conn->prepare($sql);
        $statement->bindParam(':id', $id);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }


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

    public static function getAllUserTasks()
    {
        $conn = Db::getConnection();
        $sql = "SELECT * FROM user_task";
        $statement = $conn->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function getAllUserTasksWithTaskName()
    {
        $conn = Db::getConnection();
        $sql = "SELECT user_task.*, task.type AS task_type FROM user_task INNER JOIN task ON user_task.taskId = task.id";
        $statement = $conn->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}
