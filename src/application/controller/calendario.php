<?php


class Calendario
{
    public function index(){
        if(Auth::isAuthenticated()){
            // Load page
            ViewLoader::load("calendario/templates/header");
            ViewLoader::load("calendario/index");
            ViewLoader::load("calendario/templates/footer");
        }
        else{
            // Redirect to login page
            RedirectManager::redirect("login");
        }
    }

    public function send(){
        mail("luca6469@gmail.com","Yolotest","Provaprovina");
        $mailer = new Mailer();
        $mailer->sendMail("luca.dibello@samtrevano.ch","Luca Di Bello", "Prova","culo");
    }
}