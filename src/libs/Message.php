<?php
require_once "bbdd.php";

class Message
{
    // Attributes
    private $from;
    private $to;
    private $subj;
    private $msg;
    
    // Constructor (thank god we don't need overloading here.. by the moment)
    function __construct($from, $to, $subj, $msg)
    {
        $this->from = $from;
        $this->to = $to;
        $this->subj = $subj;
        $this->msg = $msg;
    }
    
    // Getters
    public function getFrom()   { return $this->from; }
    public function getTo()     { return $this->to; }
    public function getSubj()   { return $this->subj; }
    public function getMsg()    { return $this->msg; }
    
    // Methods
    public function send()
    {
        $con = connect(Constants::db);
        $query = "INSERT INTO message(`sender`, `receiver`, `read`, `subject`, `body`) VALUES ('".self::getFrom()."', '".self::getTo()."', 0, '".self::getSubj()."', '".self::getMsg()."');";
        if($con->query($query))
        {
            disconnect($con);
            return true;
        }
        disconnect($con);
        return false; // TODO: refactor this, since false should never happen
    }
}