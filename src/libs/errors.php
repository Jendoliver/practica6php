<?php
/*
*
*   errors.php: Error library
*
*/
require_once "Constants.php";
require_once "UserEvents.php";

/********** ERROR MODELS **********/
function alertError($message, $newlocation)
{
    echo "<script type='text/javascript'>
    alert('$message');
    window.location = '$newlocation';
    </script>";
}

/********** COMMON ERRORS **********/
function errorUser($type)
{
    switch ($type)
    {
        case UserEvents::USER_ALREADY_EXISTS: alertError("El usuario especificado ya existe", $_SERVER['HTTP_REFERER']); break;
        case UserEvents::USER_DOESNT_EXIST: alertError("El usuario especificado no existe", $_SERVER['HTTP_REFERER']); break;
        case UserEvents::WRONG_PASSWORD: alertError("La contraseña es incorrecta", $_SERVER['HTTP_REFERER']); break;
        case UserEvents::PASSWORDS_DONT_MATCH: alertError("Las contraseñas no coinciden", $_SERVER['HTTP_REFERER']); break;
        case UserEvents::SAME_PASSWORD: alertError("La nueva contraseña debe ser distinta a la actual", $_SERVER['HTTP_REFERER']); break;
    }
}