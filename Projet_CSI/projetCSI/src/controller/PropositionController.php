<?php


namespace projet\controller;


use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use projet\modele\PropositionAchat;
use projet\vue\VueCreerPropositionCli;
use projet\vue\VueMessageCli;
use projet\vue\VueMessageGest;
use projet\vue\VuePropositionCli;
use Illuminate\Database\Capsule\Manager as DB1;
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
            $prop = PropositionAchat::where('idlot','=',$_GET['lot'])->where('idclient','=',$_GET['id'])->get();
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
            $vue = new VueMessageCli('La proposition a bien étée créée.<br><br>Veuillez cliquez sur les boutons ci-dessus pour naviguer sur le site');
            $vue->render();
        }
        catch(Exception $e)
        {
            $vue = new VueMessageCli($e->getMessage());
            $vue->render();
        }
    }

    public static function afficher_proposition($id){
        $props = PropositionAchat::where('idclient','=',$id)->get()->all();
        $attentes = PropositionAchat::where('idclient','=',$id)->where('etatpropal','=','en validation')->get()->all();
        $props_patientes = PropositionAchat::where('idclient','=',$id)->where('etatpropal','=','en attente')->get()->all();
        $vue = new VuePropositionCli($props,$attentes,$props_patientes);
        $vue->render();
    }

    public static function confirmer_proposition(){
        try{
            $file = parse_ini_file('src/conf/conf.ini');
            $db = new DB1();
            $db->addConnection($file);
            $db->setAsGlobal();
            $db->bootEloquent();
            $prop = PropositionAchat::where('idproposition','=',$_GET['idprop'])->get()->first();
            if($prop->first()){
                $prop->datevalidation = date('Y-m-d');
                $prop->save();
                $result = $db::select('SELECT modify_props(?)',[$prop->idlot]);
            }
            $vue = new VueMessageCli('La confirmation de la proposition a bien étée pris en compte.<br><br>Veuillez cliquez sur les boutons ci-dessus pour naviguer sur le site');
            $vue->render();
        }catch(Exception $e){
            $vue = new VueMessageCli($e->getMessage());
            $vue->render();
        }
    }

    public static function refuser_proposition(){
        try{
            $file = parse_ini_file('src/conf/conf.ini');
            $db = new DB1();
            $db->addConnection($file);
            $db->setAsGlobal();
            $db->bootEloquent();
            $prop = PropositionAchat::where('idproposition','=',$_GET['idprop'])->get()->first();
            $prop->datevalidation = '1980-01-01';
            $prop->save();
            $prop = PropositionAchat::where('idproposition','=',$_GET['idprop'])->get()->first();
            if($prop->etatpropal = 'rejetee'){
                $result = $db::select('SELECT deuxieme_propal(?)',[$prop->idlot]);
            }
            $vue = new VueMessageCli('La proposition a bien étée refusée.<br><br>Veuillez cliquez sur les boutons ci-dessus pour naviguer sur le site');
            $vue->render();
        }catch(Exception $e){
            $vue = new VueMessageCli($e->getMessage());
            $vue->render();
        }
    }

    public static function supprimer_proposition(){
        try{
            $file = parse_ini_file('src/conf/conf.ini');
            $db = new DB1();
            $db->addConnection($file);
            $db->setAsGlobal();
            $db->bootEloquent();
            if(isset($_GET['id']) && isset($_GET['lot'])){
                $prop = PropositionAchat::where('idclient','=',$_GET['id'])->where('idlot','=',$_GET['lot'])->get()->first();
                $prop->delete();
            }
            $vue = new VueMessageCli('La proposition a bien étée supprimée.<br><br>Veuillez cliquez sur les boutons ci-dessus pour naviguer sur le site');
            $vue->render();
        }catch(Exception $e){
            $vue = new VueMessageCli($e->getMessage());
            $vue->render();
        }
    }
}