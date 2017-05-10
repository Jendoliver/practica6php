<?php
/*
*
*   bbdd.php: Database related functions
*
*/
require_once "Constants.php";

function connect($database)
{
    $connection = new mysqli(Constants::dburl, Constants::dbuser, Constants::dbpass, $database);
    if ($mysqli->connect_errno) 
        echo "Error connecting to MySQL: " . $mysqli->connect_error;
    return $connection;
}

function disconnect($db)
{
    $db->close();
}