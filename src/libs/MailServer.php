<?php
require_once "bbdd.php";
require_once "Message.php";
require_once "Inbox.php";
require_once "Sent.php";

class MailServer
{
    // Attributes
    private $Inbox;
    private $Sent;
    
    // Constructor
    function __construct()
    {
        $this->Inbox = new Inbox(10);
        $this->Sent = new Sent(10);
    }
    
    // Getters
    public function getInbox() { return $this->Inbox; }
    public function getSent() { return $this->Sent; }
    
    // Methods
    public function showAllMsg()
    {
        $con = connect(Constants::db);
        $query = "SELECT * FROM message ORDER BY date DESC;";
        $res = $con->query($query);
        disconnect($con);
        createTable($res);
    }
    
    public function showInboxFrom($username) { self::getInbox()->showMsgsTo($username); }
    public function showSentFrom($username) { self::getSent()->showMsgsFrom($username); }
    
    public function sendMail($from, $to, $subj, $body)
    {
        $msg = new Message($from, $to, $subj, $body);
        $msg->send();
    }
}