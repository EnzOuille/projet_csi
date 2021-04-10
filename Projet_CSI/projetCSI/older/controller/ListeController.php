<?php
namespace projet\controller;
use Slim\Slim;
use projet\modele\Item;
use projet\modele\Liste;
use projet\vue\VueAjoutItem;
use projet\vue\VueModificationListeGest;
use projet\vue\VueParticipant3Gest;
use projet\vue\VueCreerListeGest;
class ListeController
{
    /*
    * permet d'afficher la liste de toutes les listes
    */
    public static function afficherListe()
    {
        $list = Liste::get();
        $vue = new VueParticipant3Gest($list, 'ALL_LISTE');
        $vue->render();
    }
    /*
    * affichage de la liste correspondant a son token
    */
    public static function afficherUneListe($token){
        $liste = Liste::where('token','=',$token)->first();
        $value = $liste;
        $resultat = "";
        $nombreParticipants = 0;
        $l = $liste;
        if( isset($_POST['une_liste_message'])){
            $liste->messages = $_POST['une_liste_message'];
            $liste->save();
        }
        /*
        * permet de récuperer la date courante selon le format de notre base de données
        */
        $dateCourante = date("Y") . "-" . date("m") ."-" . date("d") ;
                $item = Item::get();
                foreach ($item as $v) {
                        if ($v->liste_id == $l->no) {
                            if ($v->participant != "") {
                                if ($l->expiration < $dateCourante) {
                                    $resultat = $resultat . "<li>" . $v->participant . "</li>" ;                  
                                        if ($v->messageParticipant != "") {
                                            $resultat = $resultat . "Message : " .  $v->messageParticipant . "</br>";  ;
                                   } 
                                }
                            $nombreParticipants++;
                        }
                    }
                }
        $vue = new VueParticipant3Gest($liste,$nombreParticipants,$resultat,'AFFICHER_UNE_LISTE');
        $vue->render();
    }
    /*
    * Affiche les liste publiques et demande le token pour acceder a une liste
    */
    public static function demanderListe(){
        $listes = Liste::where('public','=','1')->get();
        $vue = new VueParticipant3Gest($listes,null,null,'DEMANDER_UNE_LISTE');
        $vue->render();
    }
    /*
    * fonction permettant l'affichage des items d'une liste
    */
    public static function afficherItemDeListe($no)
    {
        $liste = Liste::where('no', '=', $no)->first();
        $item = $liste->items()->get();
        $vue = new VueParticipant3Gest($item,null,null, 'ITEM_LISTE');
        $vue->render();
    }
    /*
    * Affichage de la page correspondant au formulaire d'une création de liste 
    */
    public static function creerListe() {
        $vue = new VueCreerListeGest("");
        $vue->render();
    }
    /*
    * fonction permettant la modifications des informations générales d'une liste
    */
    public static function modifierUneListe($tokenModif){
        $liste = Liste::where('tokenModif','=',$tokenModif)->first();
        $vue = new VueModificationListeGest($liste);
        $listItem = Item::where('liste_id','=', $liste->no)->get();
        $vue->afficherItems($listItem);
        $vue->render();
    }
    /*
    * fonction permettant l'ajout d'items dans la liste 
    */
    public static function ajoutItem($tokenModif){

        $liste = Liste::where('tokenModif','=',$tokenModif)->first();
        $item = new Item();

        $nom = $_POST['nom'];
        $nom = filter_var($nom, FILTER_SANITIZE_SPECIAL_CHARS	);
        $nom = filter_var($nom, FILTER_SANITIZE_STRING);
        $item->nom = $nom;

        $desc =  $_POST['desc'];
        $desc= filter_var($desc, FILTER_SANITIZE_SPECIAL_CHARS);
        $desc = filter_var($desc, FILTER_SANITIZE_STRING);
        $item->descr = $desc;

        $tarif = $_POST['prix'];
        $tarif = filter_var($tarif, FILTER_SANITIZE_NUMBER_FLOAT);
        $item->tarif = $tarif;

        if(isset($_POST['url'])){
            $url = $_POST['url'];
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $item->url = $url;
        }

        $item->liste_id = $liste->no;
        $item->save();
        $vue = new VueModificationListeGest($liste);
        $listItem = Item::where('liste_id','=', $liste->no)->get();
        $vue->afficherItems($listItem);
        $vue->render();
    }
    /*
    * fonction permettant la modification d'une liste
    */
    public static function modificationListe($tokenModif){

        $liste = Liste::where('tokenModif','=',$tokenModif)->first();
        $titre = $_POST['modifListe_titre'];
        $titre= filter_var($titre, FILTER_SANITIZE_SPECIAL_CHARS);
        $titre = filter_var($titre, FILTER_SANITIZE_STRING);
        $liste->titre = $titre;

        $desc =  $_POST['modifListe_description'];
        $desc = filter_var($desc, FILTER_SANITIZE_SPECIAL_CHARS);
        $desc = filter_var($desc, FILTER_SANITIZE_STRING);
        $liste->description = $desc;
        $liste->save();
        $liste = Liste::where('tokenModif','=',$tokenModif)->first();

        $vue = new VueModificationListeGest($liste);
        $listItem = Item::where('liste_id','=', $liste->no)->get();
        $vue->afficherItems($listItem);
        $vue->render();
    }
    /*
    * fonction permettant la suppression d'une liste
    */
    public static function supprimerListe($token){

            $liste = Liste::where('tokenModif', '=', $token)->first();
            $liste->delete();
            $app = Slim::getInstance();
            $app->redirect($app->urlFor('demander_une_liste'));
    }
}