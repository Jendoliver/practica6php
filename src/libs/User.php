<?php
require_once "UserEvents.php";
require_once "bbdd.php";
require_once "Event.php";

class User
{
    // Attributes
    protected $username = "undefined";
    protected $password = "undefined";
    protected $name = "undefined";
    protected $surname = "undefined";
    protected $type = "undefined";
    
    // Classic empty constructor, here forced by the impressive php overloading capabilities (jk)
    function __construct() {
        // Gipsy coding
    }
    
    // Ninja constructor
    public static function create()                 { $instance = new self(); return $instance; }
    
    // Getters
    public function getUsername()                   { return $this->username; }
    public function getPassword()                   { return $this->password; }
    public function getName()                       { return $this->name; }
    public function getSurname()                    { return $this->surname; }
    public function getType()                       { return $this->type; }
    
    // Setters (ninja constructor overload)
    public function setUsername($newUsername)       { $this->username = $newUsername; return $this; }
    public function setPassword($newPassword)       { $this->password = password_hash($newPassword, PASSWORD_DEFAULT); return $this; }
    public function setPasswordLogin($newPassword)  { $this->password = $newPassword; return $this; } // Patch
    public function setName($newName)               { $this->name = $newName; return $this; }
    public function setSurname($newSurname)         { $this->surname = $newSurname; return $this; }
    public function setType($newType)               { $this->type = $newType; return $this; }
    
    // Methods
    public function login() // Function called when an user tries to login, returns enum with event
    {
        $con = connect(Constants::db);
        $query = "SELECT * FROM user WHERE username = '".self::getUsername()."';";
        $res = $con->query($query);
        disconnect($con);
        if ($res->num_rows > 0)
        {
            $row = $res->fetch_assoc();
            if (password_verify(self::getPassword(), $row["password"]))
                return UserEvents::OK;
            return UserEvents::WRONG_PASSWORD;
        }
        return UserEvents::USER_DOESNT_EXIST;
    }
    
    public function register() // Function called when an user tries to register
    {
        $con = connect(Constants::db);
        $query = "INSERT INTO user VALUES ('".self::getUsername()."', '".self::getPassword()."', '".self::getName()."', '".self::getSurname()."', ".self::getType().");";
        if($con->query($query))
        {
            disconnect($con);
            return UserEvents::OK;
        }
        disconnect($con);
        return UserEvents::USER_ALREADY_EXISTS;
    }
    
    public function fetchInfo() // Function that fills the attributes using $this->username WHERE $this->username IS A VALID USERNAME (registered in the database)
    {
        $con = connect(Constants::db);
        $query = "SELECT * FROM user WHERE username = '".self::getUsername()."';";
        $res = $con->query($query);
        $row = $res->fetch_assoc();
        $this->password = $row["password"];
        $this->name = $row["name"];
        $this->surname = $row["surname"];
        $this->type = $row["type"];
        return $this;
    }
    
    public function updateInfo() // Function that updates the information on the db WHERE username = $this->username
    {
        $con = connect(Constants::db);
        $query = "UPDATE user SET password = '".self::getPassword()."', name = '".self::getName()."', surname = '".self::getSurname()."', type = ".self::getType()." WHERE username = '".self::getUsername()."';";
        $con->query($query);
        return;
    }
    
    public function startSession() // Function called to keep the information of the user between pages
    {
        session_start();
        $_SESSION["username"] = $this->username;
        $_SESSION["type"] = $this->type;
    }
    
    public function submitEvent($eventType) // Creates a new event of eventType associated with the user
    {
        $event = new Event($this->username, $eventType);
        $event->submit();
        return;
    }
    
    public function checkInbox()
    {
        $mail = new MailServer();
        $mail->showInboxFrom($this->username);
    }
    
    public function checkSent()
    {
        $mail = new MailServer();
        $mail->showSentFrom($this->username);
    }
    
    public function sendMail($to, $subj, $body)
    {
        $mail = new MailServer();
        $mail->sendMail($this->username, $to, $subj, $body);
    }
}