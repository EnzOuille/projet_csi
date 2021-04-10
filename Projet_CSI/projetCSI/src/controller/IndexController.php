<?php


namespace projet\controller;
use projet\index;
use projet\vue\VueAccueilGest;
use projet\vue\VueAccueilCli;

class IndexController
{
    public static function interfaceAccueilGest(){
        $vue =  new VueAccueilGest();
        $vue->render();
    }

    public static function interfaceAccueilCli(){
        $vue = new VueAccueilCli();
        $vue->render();
    }
}