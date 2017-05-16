<?php

class Sent
{
    // Attributes
    private $msgs;
    private $paginationrate;
    
    // Constructor
    function __construct($newPaginationrate) {
        $this->paginationrate = $newPaginationrate;
    }
    
    public function setMsgs($num) { $this->msgs = $num; return $this; }
    
    public function showMsgsFrom($username, $outcount)
    {
        $con = connect(Constants::db);
        $query = "SELECT `receiver`, `subject`, `date`, `body` 
                    FROM message WHERE sender = '$username' 
                    ORDER BY `date` DESC LIMIT $outcount, ".$this->msgs.";";
        $res = $con->query($query);
        disconnect($con);
        Utils::createSentTable($res);
        Utils::paginate($outcount, "outcount", $this->paginationrate, $this->msgs);
    }
}