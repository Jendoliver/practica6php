<?php
require_once "UserEvents.php";
require_once "bbdd.php";

class Event
{
    // Attributes
    private $user;
    private $type; // Holds an UserEvent
    
    // Getters
    public function getUser() { return self::$user; }
    public function getType() { return self::$type; }
    
    // Constructor
    function __construct($userCalling, $typeEvent)
    {
        $user = $userCalling;
        $type = $typeEvent;
    }
    
    // Methods
    function submit() // Function called to insert an event into the db, returns true if inserted, false on fail
    {
        $con = connect(Constants::db);
        $query = "INSERT INTO event(`user`, `type`) VALUES ('".getUser()."', '".getType()."');";
        if($con->query($query))
        {
            disconnect($con);
            return true;
        }
        disconnect($con);
        return false; // TODO: refactor this, since false should never happen
    }
}