<?php
/*
*
*   success.php: Success messages library
*
*/
require_once "Constants.php";
require_once "SuccMsgs.php";

/********** SUCCESS MODELS **********/
function alertSuccess($message, $newlocation)
{
    echo "<script type='text/javascript'>
    alert('$message');
    window.location = '$newlocation';
    </script>";
}

/********** COMMON SUCCESS **********/
function successUser($type)
{
    switch ($type)
    {
        case SuccMsgs::PASSWORD_CHANGED: alertSuccess("Contraseña cambiada con éxito", $_SERVER['HTTP_REFERER']); break;
        case SuccMsgs::MSG_SENT: alertSuccess("Mensaje enviado", $_SERVER['HTTP_REFERER']); break;
        case SuccMsgs::USER_DELETED: alertSuccess("Usuario eliminado", $_SERVER['HTTP_REFERER']); break;
        case SuccMsgs::USER_REGISTERED: alertSuccess("Usuario dado de alta", $_SERVER['HTTP_REFERER']); break;
    }
}

function lastLogin($date)
{
    alertSuccess("Última conexión: $date", $_SERVER['HTTP_REFERER']);
}