<?php
namespace projet\controller;

use Slim\Slim;
use projet\vue\VueCreerLotGest;

class LotController
{
    /*
    * Créer un lot
    */
    public static function creerLot()
    {
        $vue = new VueCreerLotGest();
        $vue->render();
    }

    public static function
}