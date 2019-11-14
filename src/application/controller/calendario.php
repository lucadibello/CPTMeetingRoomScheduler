<?php


class Calendario
{
    public function index(){
        ViewLoader::load("calendario/templates/header");
        ViewLoader::load("calendario/index");
        ViewLoader::load("calendario/templates/footer");
    }
}