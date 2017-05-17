<?php
require_once "UserEvents.php";
require_once "bbdd.php";

class Event
{
    // Attributes
    private $user;
    private $type; // Holds an UserEvent
    
    // Constructor (thank god we don't need overloading here)
    function __construct($userCalling, $typeEvent)
    {
        $this->user = $userCalling;
        $this->type = $typeEvent;
    }
    
    // Getters
    public function getUser() { return $this->user; }
    public function getType() { return $this->type; }
    
    // Methods
    public function submit() // Function called to insert an event into the db, returns true if inserted, false on fail
    {
        $con = connect(Constants::db);
        $query = "INSERT INTO event(`user`, `date`, `type`) VALUES ('".self::getUser()."', now(),'".self::getType()."');";
        if($con->query($query))
        {
            disconnect($con);
            return true;
        }
        disconnect($con);
        return false; // TODO: refactor this, since false should never happen
    }
    
    public static function fetchLastEvent($username, $type) // This returns the date of the last event of type $type from the user of username $username registered on the db
    {
        $con = connect(Constants::db);
        $query = "SELECT date FROM event WHERE user = '$username' AND type = '$type' ORDER BY date DESC;";
        $res = $con->query($query);
        disconnect($con);
        if($res->num_rows > 0)
        {
            $row = $res->fetch_row();
            return strval($row[0]);
        }
        return "undefined"; // TODO: potential refactor here,
    }
}