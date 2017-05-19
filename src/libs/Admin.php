<?php
require_once "User.php";

class Admin extends User
{
    // Classic empty constructor, here forced by the impressive php overloading capabilities (jk)
    function __construct() {
        // Gipsy coding
    }
    
    // Ninja constructor for admins
    public static function create() { $instance = new self(); return $instance; }

    public function checkUsers() // check list of all users
    {
        $con = connect(Constants::db);
        $res = $con->query("SELECT name, surname, username FROM user;");
        Utils::createTable($res);
    }
    
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
    
    public function showAllMsg() // get list of all messages (paginated 15-15 with sender, receiver, datetime, subject and readbit)
    {
        $mail = new MailServer();
        $mail->showAllMsg();
    }
    
    public function fetchLastLoginFrom($username) // get date of last login from username
    {
        return Event::fetchLastEvent($username, UserEvents::LOGIN);
    }
    
    public function fetchMsgRanking() // get ranking of users, sorted by sent message quantity
    {
        $con = connect(Constants::db);
        $query = "SELECT name, surname, username, COUNT(*) AS msgs
                    FROM user INNER JOIN message ON user.username = message.sender
                    GROUP BY sender
                    ORDER BY msgs DESC;";
        if($res = $con->query($query))
        {
            disconnect($con);
            Utils::createTable($res);
        }
    }
}