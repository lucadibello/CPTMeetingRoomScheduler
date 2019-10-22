<?php
/**
 * Created by PhpStorm.
 * User: luca6
 * Date: 01.10.2019
 * Time: 15:17
 */

class RedirectManager
{
    public static function redirect($path){
        Header("Location: " . URL . $path);
        exit();
    }

    public static function buildUrl($path){
        return URL . $path;
    }
}