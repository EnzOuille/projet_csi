<?php


namespace projet\controller;

use Illuminate\Database\Eloquent\Model;
use projet\modele\Vente;
use Slim\Slim;
use projet\modele\Client;
use projet\vue\VueCompteCli;

class ClientController
{

    public static function afficherCompte($id)
    {
        $client = Client::where('idclient', $id)->get()->all();
        $vente = Vente::select('idvente', 'vente.montant', 'benefice', 'vente.idlot', 'vente.idclient as idclientvente', 'propositionachat.idclient')->join('lot', 'vente.idlot', '=', 'lot.idlot')
            ->join('propositionachat', 'lot.idlot', '=', 'propositionachat.idlot')->get();
        $vue = new VueCompteCli($client[0], $vente);
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