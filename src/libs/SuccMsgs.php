<?php
require_once "BasicEnum.php";

abstract class SuccMsgs extends BasicEnum
{
    const PASSWORD_CHANGED = 1;
    const MSG_SENT = 2;
    const USER_DELETED = 3;
    const USER_REGISTERED = 4;
}