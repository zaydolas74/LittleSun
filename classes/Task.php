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

        // Check if the user is on time-off on the selected date
        $checkTimeOffSql = "SELECT * FROM time_off WHERE userId = :userId AND :date BETWEEN start_time AND end_time";
        $checkStatement = $conn->prepare($checkTimeOffSql);
        $checkStatement->bindParam(':userId', $userId);
        $checkStatement->bindParam(':date', $date);
        $checkStatement->execute();

        if ($checkStatement->rowCount() > 0) {
            // User is on time-off on this date, throw an exception
            throw new Exception('User has time-off on this date. Cannot assign task.');
        }

        // If user is not on time-off, proceed with task assignment
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
            throw new Exception('End time must be greater than start time');
            return false;
        }
    }


    public function editTask($id, $type)
    {
        $conn = Db::getConnection();
        $sql = "UPDATE task SET type = :type WHERE id = :id";
        $statement = $conn->prepare($sql);
        $statement->bindParam(':id', $id);
        $statement->bindParam(':type', $type);
        $result = $statement->execute();
        return $result;
    }

    public static function deleteTask($id)
    {
        $conn = Db::getConnection();
        $sql = "DELETE FROM task WHERE id = :id";
        $statement = $conn->prepare($sql);
        $statement->bindParam(':id', $id);
        $result = $statement->execute();
        return $result;
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

    public static function getAllUserTasksById($userId)
    {
        $conn = Db::getConnection();
        $sql = "SELECT * FROM user_task WHERE userId = :userId";
        $statement = $conn->prepare($sql);
        $statement->bindParam(':userId', $userId);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function getTaskByUserId($userId)
    {
        $conn = Db::getConnection();
        $sql = "SELECT user_task.*, task.type AS task_type FROM user_task INNER JOIN task ON user_task.taskId = task.id WHERE userId = :userId";
        $statement = $conn->prepare($sql);
        $statement->bindParam(':userId', $userId);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function deleteUserTask($id)
    {
        $conn = Db::getConnection();
        $sql = "DELETE FROM user_task WHERE id = :id";
        $statement = $conn->prepare($sql);
        $statement->bindParam(':id', $id);
        $result = $statement->execute();
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

    //2 inner joins with info of user and task with profile picture
    public static function getAllUserTasksWithTaskNameAndUserInfo()
    {
        $conn = Db::getConnection();
        $sql = "SELECT user_task.*, task.type AS task_type, user.name AS user_name, user.profile_picture AS user_profile_picture FROM user_task INNER JOIN task ON user_task.taskId = task.id INNER JOIN user ON user_task.userId = user.id";
        $statement = $conn->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function createTaskType($type)
    {
        $conn = Db::getConnection();
        $sql = "INSERT INTO task (type) VALUES (:type)";
        $statement = $conn->prepare($sql);
        $statement->bindParam(':type', $type);
        $statement->execute();
        return $conn->lastInsertId();
    }
}
