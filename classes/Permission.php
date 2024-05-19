<?php
include_once(__DIR__ . '/Db.php');

class Permission
{
    private $user_id;
    private $task_id;

    public function save()
    {
        $conn = Db::getConnection();
        $sql = "INSERT INTO permission (userId, taskId) VALUES (:user_id, :task_id)";
        $statement = $conn->prepare($sql);
        $statement->bindValue(':user_id', $this->user_id);
        $statement->bindValue(':task_id', $this->task_id);
        $result = $statement->execute();
        return $result;
    }

    public function delete()
    {
        $conn = Db::getConnection();
        $sql = "DELETE FROM permission WHERE userId = :user_id AND taskId = :task_id";
        $statement = $conn->prepare($sql);
        $statement->bindValue(':user_id', $this->user_id);
        $statement->bindValue(':task_id', $this->task_id);
        $result = $statement->execute();
        return $result;
    }

    public function getTasksByUserId($userId)
    {
        $conn = Db::getConnection();
        $sql = "SELECT * FROM permission WHERE userId = :user_id";
        $statement = $conn->prepare($sql);
        $statement->bindValue(':user_id', $userId);
        $statement->execute();
        $tasks = $statement->fetchAll();
        return $tasks;
    }

    public function getUsersByTaskId($taskId)
    {
        $conn = Db::getConnection();
        $sql = "SELECT * FROM permission WHERE taskId = :task_id";
        $statement = $conn->prepare($sql);
        $statement->bindValue(':task_id', $taskId);
        $statement->execute();
        $users = $statement->fetchAll();
        return $users;
    }

    public static function getTaskIdByUserId($userId)
    {
        $conn = Db::getConnection();
        $sql = "SELECT taskId FROM permission WHERE userId = :user_id";
        $statement = $conn->prepare($sql);
        $statement->bindValue(':user_id', $userId);
        $statement->execute();
        $tasks = $statement->fetchAll();
        return $tasks;
    }

    public static function addUserPermission($userId, $taskId)
    {
        $conn = Db::getConnection();
        $sql = "INSERT INTO permission (userId, taskId) VALUES (:user_id, :task_id)";
        $statement = $conn->prepare($sql);
        $statement->bindValue(':user_id', $userId);
        $statement->bindValue(':task_id', $taskId);
        return $statement->execute();
    }

    // Method to remove a permission from the database
    public static function removeUserPermission($userId, $taskId)
    {
        $conn = Db::getConnection();
        $sql = "DELETE FROM permission WHERE userId = :user_id AND taskId = :task_id";
        $statement = $conn->prepare($sql);
        $statement->bindValue(':user_id', $userId);
        $statement->bindValue(':task_id', $taskId);
        return $statement->execute();
    }

    //

    /**
     * Get the value of user_id
     */
    public function getUser_id()
    {
        return $this->user_id;
    }

    /**
     * Set the value of user_id
     *
     * @return  self
     */
    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * Get the value of task_id
     */
    public function getTask_id()
    {
        return $this->task_id;
    }

    /**
     * Set the value of task_id
     *
     * @return  self
     */
    public function setTask_id($task_id)
    {
        $this->task_id = $task_id;

        return $this;
    }
}
