<?php
/**
 * Created by PhpStorm.
 * User: luca6
 * Date: 03.10.2019
 * Time: 13:49
 */

class Admin
{
    const STATUS_NOT_LOGGED = 1;
    const STATUS_BAD_PERMISSIONS = 2;
    const STATUS_OK = -1;

    public function index(){
        $status = $this->is_user_valid();
        if($status == self::STATUS_OK){
            $this->dashboard();
        }
        elseif($status == self::STATUS_BAD_PERMISSIONS){
            echo "Non hai permessi necessari per accedere a questa funzionalità.";
        }
        elseif($status == self::STATUS_NOT_LOGGED){
            RedirectManager::redirect("home");
        }
    }

    // Load admin panel dashboard
    public function dashboard(){
        if($this->is_user_valid() == self::STATUS_OK){
            ViewLoader::load("admin/templates/header");
            ViewLoader::load("admin/index");
            ViewLoader::load("admin/templates/footer");
        }
        else{
            RedirectManager::redirect("admin");
        }
    }

    // Load admin panel user management tool
    public function utenti(){
        if($this->is_user_valid() == self::STATUS_OK){
            ViewLoader::load("admin/templates/header");
            ViewLoader::load("admin/gestione_utenti");
            ViewLoader::load("admin/templates/footer");
        }
        else{
            RedirectManager::redirect("admin");
        }
    }

    // This function checks if a user can access any of the admin panel functions
    private function is_user_valid(): int{
        if(Auth::isAuthenticated()){
            $user_perms = PermissionManager::getPermissions();
            if($user_perms instanceof Permissions && $user_perms->getPermissionName() == ADMIN_PANEL_USER_PERMISSION_GROUP){
                return self::STATUS_OK;
            }
            else{
                return self::STATUS_BAD_PERMISSIONS;
            }
        }
        else{
            return self::STATUS_NOT_LOGGED;
        }
    }
}