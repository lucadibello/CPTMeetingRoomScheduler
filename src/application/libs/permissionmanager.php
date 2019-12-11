<?php
/**
 * Created by PhpStorm.
 * User: luca6
 * Date: 20.09.2019
 * Time: 14:28
 */

class PermissionManager
{
    public static function getPermissions(): Permissions{
        if(isset($_SESSION["permissions"]) && $_SESSION["permissions"] instanceof Permissions){
            return $_SESSION["permissions"];
        }
        else{
            return false;
        }
    }
}