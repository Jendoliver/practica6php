<?php
require_once "User.php";

class Admin extends User
{
    //TODO: add methods for...
    public function checkUsers()    // - check list of all users
    {
        $con = connect(Constants::db);
        $query = "SELECT * FROM user;";
        if($con->query($query))
        {
            disconnect($con);
            // TODO!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        }
    }
    // - register users (normal and admins)
    public function delet($username) // Function called to delete an user. Returns true if correctly deleted, false if error
    {
        $con = connect(Constants::db);
        $query = "DELETE FROM user WHERE username = '$username';";
        if($con->query($query))
        {
            disconnect($con);
            return true;
        }
        disconnect($con);
        return false;
    }
    public function showAllMsg() // - get list of all messages (paginated 15-15 with sender, receiver, datetime, subject and readbit)
    {
        $mail = new MailServer();
        $mail->showAllMsg();
    }
    
    // - get datetime from last login of a given user
    // - get ranking of users, sorted by sent message quantity
}