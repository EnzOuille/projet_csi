<?php


namespace projet\controller;


use Exception;
use Illuminate\Database\Eloquent\Model;
use projet\modele\PropositionAchat;
use projet\vue\VueCreerPropositionCli;
use projet\vue\VuePropositionCli;
use Slim\Slim;

class PropositionController
{

    public static function creer_affichage_proposition()
    {
        $vue = new VueCreerPropositionCli();
        $vue->render();
    }

    public static function creer_proposition(){
        try
        {
            $prop = PropositionAchat::where('idlot','=',$_GET['lot'])->where('idclient','=',$_GET['id'])->get()->first();
            if ($prop->first()){
                $prop->montant = $_POST['montant_propal'];
                $prop->save();
            }else{
                $prop = new PropositionAchat();
                $prop->montant = $_POST['montant_propal'];
                $prop->nbmodifs = 0;
                $prop->dateproposition = date('Y-m-d');
                $prop->etatpropal= 'en attente';
                $prop->idclient = $_GET['id'];
                $prop->idlot = $_GET['lot'];
                $prop->save();
            }

        }
        catch(Exception $e)
        {
            dd($e->getMessage());
        }

        $app = Slim::getInstance();
        $url = $app->urlFor('page_index_cli');
        $app->redirect($url);
    }

    public static function afficher_proposition($id){
        $props = PropositionAchat::where('idclient','=',$id)->get()->all();
        $vue = new VuePropositionCli($props);
        $vue->render();
    }
}