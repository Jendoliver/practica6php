<?php

class Inbox
{
    // Attributes
    private $msgs;
    private $paginationrate;
    
    // Constructor
    function __construct($newPaginationrate) {
        $this->paginationrate = $newPaginationrate;
    }
    
    public function setMsgs($num) { $this->msgs = $num; return $this; }
    
    public function showMsgsTo($username, $incount)
    {
        $con = connect(Constants::db);
        $query = "SELECT `sender`, `subject`, `date`, `read`, `body` 
                    FROM message WHERE receiver = '$username' 
                    ORDER BY `date` DESC LIMIT $incount, ".$this->paginationrate.";";
        $res = $con->query($query);
        disconnect($con);
        Utils::createInboxTable($res);
        Utils::paginate($incount, "incount", $this->paginationrate, $this->msgs);
    }
}