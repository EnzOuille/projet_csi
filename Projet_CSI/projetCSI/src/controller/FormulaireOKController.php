<?php

namespace projet\controller;
use projet\index;
use projet\vue\VueListeCree;
use projet\modele\Liste;
use projet\modele\Item;
use projet\vue\VueImageAjout;
use projet\vue\VueCreerListe;

class FormulaireOKController
{
    /*
    * fonction pour creer une liste
    */
    public static function control(){
        if (isset($_POST['creer'])){
            $l = new Liste();
            /*
            * Génération des token de modification de liste et de partage de liste
            */
            $tokenGenerated = "";
            $token = openssl_random_pseudo_bytes(32);
            $token = bin2hex($token);
            $tokenGenerated = $token;
  
            $tokenModifGenerated = "";
            $tokenModif = openssl_random_pseudo_bytes(32);
            $tokenModif = bin2hex($tokenModif);
            $tokenModifGenerated = $tokenModif;
            $titre = $_POST['titre'];
            $description = $_POST['description'];
            $date =  $_POST['expiration'];
            $dateCourante = date("Y") . "-" . date("m") ."-" . date("d");
            /*
            * Si la date est incorrecte soit inférieur à la date actuelle il est impossible de créer la liste
            * ce qui affiche une erreur à la page de création de liste
            */
            if ($date < $dateCourante) {
                $vue =  new VueCreerListe("erreurDate");
                $vue->render();
            } else {
            $titre = filter_var($titre, FILTER_SANITIZE_SPECIAL_CHARS);
            $titre = filter_var($titre, FILTER_SANITIZE_STRING);
            $description = filter_var($description, FILTER_SANITIZE_SPECIAL_CHARS);
            $description = filter_var($description, FILTER_SANITIZE_STRING);
            $date = filter_var($date, FILTER_SANITIZE_SPECIAL_CHARS);
            $date = filter_var($date, FILTER_SANITIZE_STRING);
            /*
            * Si la check box est validée on rentre dans le if pour rendre la liste publique
            * sinon elle rend la liste privée
            */
            if (isset($_POST['liste_publique'])) {
                $l->public = 1;
            } else 
                $l->public = null;
            /*
            * On associe les données filtrées à la liste null pour ensuite l'ajouter dans la base de données
            */
            $l->titre = $titre;
            $l->description = $description;
            $l->expiration = $date;
            $l->user_id = null;
            $l->token = $tokenGenerated;
            $l->tokenModif = $tokenModifGenerated;
            $res = $l->save();
            $vue =  new VueListeCree($l);
            $vue->render();
            }
          }
        
    }
}