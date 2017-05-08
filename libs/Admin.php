<?php
require_once "User.php";

class Admin extends User
{
    //TODO: add methods for...
    // - check list of all users
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
    // - get list of all messages (paginated 15-15 with sender, receiver, datetime, subject and readbit)
    // - get datetime from last login of a given user
    // - get ranking of users, sorted by sent message quantity
}