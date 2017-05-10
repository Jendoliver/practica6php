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
        case UserEvents::USER_ALREADY_EXISTS: alertError("El usuario especificado ya existe", Constants::index); break;
        case UserEvents::USER_DOESNT_EXIST: alertError("El usuario especificado no existe", Constants::index); break;
        case UserEvents::WRONG_PASSWORD: alertError("La contraseña es incorrecta", Constants::index); break;
        case UserEvents::PASSWORDS_DONT_MATCH: alertError("Las contraseñas no coinciden", Constants::index); break;
    }
}