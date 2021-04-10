<?php
namespace projet\controller;
use Slim\Slim;
use projet\modele\Produit;
use projet\vue\VueProduit;

class ProduitController
{

    /*
    * Afficher tout les produits
    */
    public static function afficherToutProduits()
    {
        $produits = Produit::get();
        $vue = new VueProduit($produits);
        $vue->render();
    }

}