<?php
/**
 * Created by PhpStorm.
 * User: luca6
 * Date: 03.10.2019
 * Time: 14:29
 */

class DashboardModel
{
    //TODO: FINISH CHART GENERATION FROM DATABASE DATA
    public static function get_n_users_per_permission_type(){
        return self::getPermissionTypes();
    }

    private static function getPermissionTypes(){
        $result = DB::query("SELECT nome FROM tipo_utente");
        var_dump($result);
        exit();
    }
}