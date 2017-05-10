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
    
    public function showMsgsTo($username)
    {
        $con = connect(Constants::db);
        $query = "SELECT * FROM message WHERE receiver = '$username' ORDER BY date DESC;";
        $res = $con->query($query);
        disconnect($con);
        createTable($res);
    }
}