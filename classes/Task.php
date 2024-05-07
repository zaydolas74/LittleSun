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
}
