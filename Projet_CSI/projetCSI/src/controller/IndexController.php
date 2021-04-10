<?php


namespace projet\controller;
use projet\index;
use projet\vue\VueAccueil;

class IndexController
{
    public static function interfaceAccueil(){
        $vue =  new VueAccueil();
        $vue->render();
    }
}