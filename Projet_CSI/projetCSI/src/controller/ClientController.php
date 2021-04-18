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

    public static function modifierSoldeCompte($id){
        echo 'Problème';
        $app = Slim::getInstance();
        $url = $app->urlFor('afficher_compte_client', array('id' => $id));
        $client = Client::find($id);
        $client->solde = $_POST['nouveausolde'];
        $client->save();
        $app->redirect($url);
    }

}