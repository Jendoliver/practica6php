<?php
require_once "bbdd.php";
require_once "Utils.php";
require_once "Message.php";
require_once "Inbox.php";
require_once "Sent.php";

class MailServer
{
    // Attributes
    private $Inbox;
    private $Sent;
    private $totalmsgs;
    private $paginationrate;
    
    // Constructor
    function __construct()
    {
        $this->Inbox = new Inbox(10);
        $this->Sent = new Sent(10);
        $this->paginationrate = 15;
    }
    
    // Getters
    public function getInbox() { return $this->Inbox; }
    public function getSent() { return $this->Sent; }
    
    // Methods
    public function refresh($username)
    {
        $con = connect(Constants::db);
        $res = $con->query("SELECT COUNT(*) FROM message WHERE receiver = '$username';");
        $row = $res->fetch_row();
        $this->Inbox->setMsgs($row[0]);
        $res = $con->query("SELECT COUNT(*) FROM message WHERE sender = '$username';");
        $row = $res->fetch_row();
        $this->Sent->setMsgs($row[0]);
        $res = $con->query("SELECT COUNT(*) FROM message;");
        $row = $res->fetch_row();
        $this->totalmsgs = $row[0];
        disconnect($con);
    }
    public function showAllMsg($totalcount)
    {
        $con = connect(Constants::db);
        $query = "SELECT `idmessage`, `sender`, `receiver`, `subject`, `date`, `read`, `body` 
                    FROM message ORDER BY date DESC 
                    LIMIT $totalcount, ".$this->paginationrate;
        $res = $con->query($query);
        disconnect($con);
        Utils::createAllMsgsTable($res);
        Utils::paginate($totalcount, "totalcount", $this->paginationrate, $this->totalmsgs);
    }
    
    public function showInboxFrom($username) { self::getInbox()->showMsgsTo($username); }
    public function showSentFrom($username) { self::getSent()->showMsgsFrom($username); }
    
    public function sendMail($from, $to, $subj, $body)
    {
        $msg = new Message($from, $to, $subj, $body);
        $msg->send();
    }
}