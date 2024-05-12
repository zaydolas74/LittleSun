<?php
include_once(__DIR__ . '/Db.php');
class User
{
    private $name;
    private $username;
    private $email;
    private $password;
    private $photo;
    private $location_id;


    public function save()
    {
        $conn = Db::getConnection();
        $sql = "INSERT INTO user (type, name, username, email, password, profile_picture, location_id) VALUES ('User', :name, :username, :email, :password, :photo, :location_id)";
        $statement = $conn->prepare($sql);
        $statement->bindValue(':name', $this->name);
        $statement->bindValue(':username', $this->username);
        $statement->bindValue(':email', $this->email);
        $statement->bindValue(':password', $this->password);
        $statement->bindValue(':photo', $this->photo);
        $statement->bindValue(':location_id', $this->location_id);
        $result = $statement->execute();
        return $result;
    }

    public function saveManager()
    {
        $conn = Db::getConnection();
        $sql = "INSERT INTO user (type, name, username, email, password, profile_picture, location_id) VALUES ('Manager', :name, :username, :email, :password, :photo, :location_id)";
        $statement = $conn->prepare($sql);
        $statement->bindValue(':name', $this->name);
        $statement->bindValue(':username', $this->username);
        $statement->bindValue(':email', $this->email);
        $statement->bindValue(':password', $this->password);
        $statement->bindValue(':photo', $this->photo);
        $statement->bindValue(':location_id', $this->location_id);
        $result = $statement->execute();
        return $result;
    }
    
    public function login()
    {
        $conn = Db::getConnection();
        $sql = "SELECT * FROM user WHERE email = :email";
        $statement = $conn->prepare($sql);
        $statement->bindValue(':email', $this->email);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if ($result && password_verify($this->password, $result['password'])) {
            return $result;
        } else {
            throw new Exception('Invalid email or password');
            return false;
        }
    }

    public static function getAllData()
    {
        $conn = Db::getConnection();
        $sql = "SELECT * FROM user";
        $statement = $conn->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the value of username
     *
     * @return  self
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of photo
     */ 
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set the value of photo
     *
     * @return  self
     */ 
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get the value of location_id
     */ 
    public function getLocation_id()
    {
        return $this->location_id;
    }

    /**
     * Set the value of location_id
     *
     * @return  self
     */ 
    public function setLocation_id($location_id)
    {
        $this->location_id = $location_id;

        return $this;
    }
}
