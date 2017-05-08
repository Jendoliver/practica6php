<?php
require_once "bbdd.php";

class Message
{
    // Attributes
    private $from;
    private $to;
    private $subj;
    private $msg;
    
    // Constructor
    function __construct($from, $to, $subj, $msg)
    {
        self::$from = $from;
        self::$to = $to;
        self::$subj = $subj;
        self::$msg = $msg;
    }
    
    // Getters
    public function getFrom() { return self::$from; }
    public function getTo() { return self::$to; }
    public function getSubj() { return self::$subj; }
    public function getMsg() { return self::$msg; }
    
    // Methods
    public function send()
    {
        $con = connect(Constants::db);
        $query = "INSERT INTO message(`sender`, `receiver`, `read`, `subject`, `body`) VALUES ('".getFrom()."', '".getTo()."', 0, '".getSubj()."', '".getMsg()."');";
        if($con->query($query))
        {
            disconnect($con);
            return true;
        }
        disconnect($con);
        return false; // TODO: refactor this, since false should never happen
    }
}