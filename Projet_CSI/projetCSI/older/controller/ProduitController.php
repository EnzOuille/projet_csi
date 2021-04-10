<?php
namespace projet\controller;
use Slim\Slim;
use projet\modele\Produit;
use projet\vue\VueProduitGest;

class ProduitController
{

    /*
    * Afficher tout les produits
    */
    public static function afficherToutProduits()
    {
        $produits = Produit::get();
        $vue = new VueProduitGest($produits);
        $vue->render();
    }

}