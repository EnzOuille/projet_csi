<?php


namespace projet\controller;


use projet\modele\PropositionAchat;
use projet\vue\VuePropositionCli;

class PropositionController
{

    public static function afficherPropals($id)
    {
        $propals = PropositionAchat::where('idclient',$id);
        $vue = new VuePropositionCli($propals);
        $vue->render();
    }


}