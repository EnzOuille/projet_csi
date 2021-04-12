<?php
namespace projet\controller;
use Slim\Slim;
use projet\modele\Produit;
use projet\vue\VueProduitGest;
use projet\vue\VueCreerProduitGest;

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

    /*
    * Créer un produit
    */
    public static function creerProduit()
    {
        $vue = new VueCreerProduitGest();
        $vue->render();
    }

}