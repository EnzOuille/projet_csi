<?php


namespace projet\controller;
use projet\index;
use projet\modele\Produit;
use projet\vue\VueAccueilGest;
use projet\vue\VueCompte;

class IndexController
{
    public static function interfaceListe(){
        $vue =  new VueAccueilGest();
        $vue->render();
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