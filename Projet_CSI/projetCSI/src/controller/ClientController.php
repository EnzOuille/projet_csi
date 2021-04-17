<?php


namespace projet\controller;

use Illuminate\Database\Eloquent\Model;
use Slim\Slim;
use projet\modele\Client;
use projet\vue\VueCompteCli;

class ClientController
{

    public static function afficherCompte($id)
    {
        $client = Client::where('idclient', $id)->get()->all();
        $vue = new VueCompteCli($client);
        $vue->render();
    }


}