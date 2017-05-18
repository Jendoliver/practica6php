<?php
require_once "../libs/User.php";

$id = $_GET["id"];
$response = array();

$con = connect(Constants::db);
$res = $con->query("SELECT * FROM message WHERE idmessage = $id;");
$row = $res->fetch_assoc();
$user = User::create()->setUsername($row["receiver"])->submitEvent(UserEvents::MSG_CHECK);
if($con->query("UPDATE message SET `read` = 1 WHERE idmessage = $id;"))
    $response["success"] = true;
else
    $response["success"] = false;

echo json_encode($response);