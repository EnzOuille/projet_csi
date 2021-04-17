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
    public static function afficher_creer_produit()
    {
        $vue = new VueCreerProduitGest();
        $vue->render();
    }

    public static function creer_produit(){
        $app = Slim::getInstance();
        $url = $app->urlFor('page_index_gest');
        $prod = new Produit();
        $prod->type = $_POST['creerProduit_type'];
        $prod->description = $_POST['creerProduit_description'];
        $prod->save();
        $app->redirect($url);
    }

}