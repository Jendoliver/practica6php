<?php
require_once "UserEvents.php";
require_once "bbdd.php";

class User
{
    // Attributes
    private $username;
    private $password;
    private $name;
    private $surname;
    private $type;
    
    function __construct($newUsername, $newPassword, $newName, $newSurname, $newType) {
        $username = $newUsername;
        $password = $newPassword;
        $name = $newName;
        $surname = $newSurname;
        $type = $newType;
    }
    
    // Getters
    public function getUsername() { return self::$username; }
    public function getPassword() { return self::$password; }
    public function getName() { return self::$name; }
    public function getSurname() { return self::$surname; }
    public function getType() { return self::$type; }
    
    // Setters
    public function setPassword($newPassword) { self::$password = $newPassword; }
    
    // Methods
    public function login() // Function called when an user tries to login, returns enum with event
    {
        $con = connect(Constants::db);
        $query = "SELECT * FROM user WHERE username = '".getUsername()."';";
        $res = $con->query($query);
        disconnect($con);
        if ($res->num_rows > 0)
        {
            $row = $res->fetch_assoc();
            if ($row["password"] == password_verify(getPassword(), $row["password"]))
                return UserEvents::OK;
            return UserEvents::WRONG_PASSWORD;
        }
        return UserEvents::USER_DOESNT_EXIST;
    }
    
    public function register() // Function called when an user tries to register
    {
        $con = connect(Constants::db);
        $query = "INSERT INTO user VALUES ('".getUsername()."', '".password_hash(getPassword(), PASSWORD_DEFAULT)."', '".getName()."', '".getSurname()."', ".getType().");";
        if($con->query($query))
        {
            disconnect($con);
            return UserEvents::OK;
        }
        disconnect($con);
        return UserEvents::USER_ALREADY_EXISTS;
    }
    
    public function startSession() // Function called to keep the information of the user between pages
    {
        session_start();
        $_SESSION["username"] = self::$username;
        $_SESSION["password"] = self::$password;
        $_SESSION["name"] = self::$name;
        $_SESSION["surname"] = self::$surname;
        $_SESSION["type"] = self::$type;
    }
    public function closeSession() { $_SESSION = array(); }
    
    public function submitEvent($eventType) // Creates a new event of eventType associated with the user
    {
        $event = new Event(self::$username, $eventType);
        $event->submit();
    }
}