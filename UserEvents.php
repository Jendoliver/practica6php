<?php
require_once "BasicEnum.php";

abstract class UserEvents extends BasicEnum
{
    // Login and register events (not tracking events)
    const OK = 1;
    const USER_ALREADY_EXISTS = 2;
    const USER_DOESNT_EXIST = 3;
    const WRONG_PASSWORD = 4;
    
    // Tracking events
    const LOGIN = 'I';
    const MSG_CHECK = 'C';
    const MSG_VIEW = 'R';
}