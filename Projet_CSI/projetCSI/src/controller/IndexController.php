<?php


namespace projet\controller;
use projet\index;
use projet\modele\Produit;
use projet\vue\VueAccueil;
use projet\vue\VueCompte;

class IndexController
{
    public static function interfaceListe(){
//        $vue =  new VueAccueil();
//        $vue->render();
        echo(Produit::get());
    }

    public static function creerCompte(){
        $vue = new VueCompte('creerCompte');
        $vue->render();
    }

    public static function confirmCompte(){
        $vue = new VueCompte('confirm');
        $vue->render();
    }
}