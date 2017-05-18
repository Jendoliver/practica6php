<?php
require_once "../libs/bbdd.php";

$id = $_GET["id"];

$con = connect(Constants::db);
$res = $con->query("SELECT * FROM message WHERE idmessage = $id");
$row = $res->fetch_assoc();
echo json_encode($row);
