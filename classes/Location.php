<?php
include_once(__DIR__ . '/Db.php');
class Location{
    private $hub_location;

    public function addLocation(){
        $conn = Db::getConnection();
        $sql = "INSERT INTO location (location_name) VALUES (:location_name)";
        $statement = $conn->prepare($sql);
        $statement->bindValue(':location_name', $this->hub_location);
        $result = $statement->execute();
        return $result;
    }

    public function removeLocation(){
        $conn = Db::getConnection();
        $sql = "DELETE FROM location WHERE location_name = :location_name";
        $statement = $conn->prepare($sql);
        $statement->bindValue(':location_name', $this->hub_location);
        $result = $statement->execute();
        return $result;
    }

    public function editLocation(){
        $conn = Db::getConnection();
        $sql = "UPDATE location SET location_name = :location_name WHERE location_name = :location_name";
        $statement = $conn->prepare($sql);
        $statement->bindValue(':location_name', $this->hub_location);
        $result = $statement->execute();
        return $result;
    }

    public static function getAllLocations(){
        $conn = Db::getConnection();
        $sql = "SELECT * FROM location";
        $statement = $conn->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public static function getLocationById($id){
        $conn = Db::getConnection();
        $sql = "SELECT * FROM location WHERE id = :id";
        $statement = $conn->prepare($sql);
        $statement->bindParam(':id', $id);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * Get the value of hub_location
     */ 
    public function getHub_location()
    {
        return $this->hub_location;
    }

    /**
     * Set the value of hub_location
     *
     * @return  self
     */ 
    public function setHub_location($hub_location)
    {
        $this->hub_location = $hub_location;

        return $this;
    }
}