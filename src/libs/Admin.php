<?php
require_once "User.php";

class Admin extends User
{
    // Classic empty constructor, here forced by the impressive php overloading capabilities (jk)
    function __construct() {
        // Gipsy coding
    }
    
    // Ninja constructor for admins
    public static function create()             { $instance = new self(); return $instance; }
    
    //TODO: add methods for...
    public function checkUsers()    // - check list of all users
    {
        $con = connect(Constants::db);
        $query = "SELECT * FROM user;";
        if($con->query($query))
        {
            disconnect($con);
            // TODO!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        }
    }
    /* MIGHT BE UNNECESARY
    public function registerUser($User, $type=0) // Registers an User with type 0 (Basic) or 1 (Admin) -- DEFAULT 0
    {
        $con = connect(Constants::db);
        $query = "INSERT INTO user VALUES ('".$User->getUsername()."', '".$User->getPassword()."', '".$User->getName()."', '".$User->getSurname()."', ".$type.");";
        if($con->query($query))
        {
            disconnect($con);
            return UserEvents::OK;
        }
        disconnect($con);
        return UserEvents::USER_ALREADY_EXISTS;
    }*/
    
    public function deleteUser($username) // Function called to delete an user. Returns true if correctly deleted, false if error
    {
        $con = connect(Constants::db);
        $con->query("DELETE FROM event WHERE user = '$username';");
        $query = "DELETE FROM user WHERE username = '$username';";
        if($con->query($query))
        {
            disconnect($con);
            return true;
        }
        disconnect($con);
        return false;
    }
    
    public function showAllMsg() // - get list of all messages (paginated 15-15 with sender, receiver, datetime, subject and readbit)
    {
        $mail = new MailServer();
        $mail->showAllMsg();
    }
    
    public function fetchLastLoginFrom($username) // get date of last login from username
    {
        return Event::fetchLastEvent($username, UserEvents::LOGIN);
    }
    
    public function fetchMsgRanking() // - get ranking of users, sorted by sent message quantity
    {
        $con = connect(Constants::db);
        $query = "SELECT username, COUNT(sender) AS msgs
                    FROM user INNER JOIN message
                    GROUP BY sender
                    ORDER BY msgs DESC;";
        if($res = $con->query($query))
        {
            disconnect($con);
            createTable($res);
        }
    }
}