<?php
require_once "bbdd.php";

abstract class Utils
{
    public static function createTable($res)
    {
        
    }
    
    public static function fetchUsersOption()
    {
        $con = connect(Constants::db);
        $res = $con->query("SELECT username, name, surname FROM user");
        while($row = $res->fetch_assoc())
        {
            echo "<option value='".$row["username"]."'>".$row["name"]." ".$row["surname"]." (".$row["username"].")</option>";
        }
    }
}