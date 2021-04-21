<?php
namespace projet\controller;
use Exception;
use Illuminate\Database\Eloquent\Model;
use projet\vue\VueMessageGest;
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
        $produits = Produit::orderby('idproduit')->get();
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
        try {
            $app = Slim::getInstance();
            $url = $app->urlFor('page_index_gest');
            $prod = new Produit();
            $prod->type = $_POST['creerProduit_type'];
            $prod->description = $_POST['creerProduit_description'];
            $prod->save();
            $vue = new VueMessageGest('Le produit a bien été créé.<br><br>Cliquez sur les boutons ci-dessus pour naviguer sur le site');
            $vue->render();
        }catch (Exception $e){
            $vue = new VueMessageGest($e->getMessage());
            $vue->render();
        }
    }

}