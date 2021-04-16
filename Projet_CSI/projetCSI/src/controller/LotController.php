<?php
namespace projet\controller;

use Illuminate\Database\Eloquent\Model;
use projet\modele\Lot;
use Slim\Slim;
use projet\vue\VueCreerLotGest;

class LotController
{
    /*
    * Créer un lot
    */
    public static function afficher_creer_lot()
    {
        $vue = new VueCreerLotGest();
        $vue->render();
    }

    public static function creerLot(){
        $app = Slim::getInstance();
        $url = $app->urlFor('page_index_gest');
        $lot = new Lot();
        $lot->description = $_POST['creerlot_description'];
        $lot->prixestime = $_POST['creerlot_prixestime'];
        $lot->prixminimal = $_POST['creerlot_prixminimal'];
        $lot->datedebut = $_POST['creerlot_datedebut'];
        $lot->datefin = $_POST['creerlot_datefin'];
        $lot->save();
        $app->redirect($url);
    }
}