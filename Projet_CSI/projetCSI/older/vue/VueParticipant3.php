<?php

namespace projet\vue;

use projet\modele\Item;
use projet\modele\Liste;

class VueParticipant3 extends VuePrincipale
{

    private $liste, $typeAff;
    private  $urlDemandeListe;
    private $nombreParticipants = 0;
    private $nomsParticipants = array();
    private $resultat;

    public function __construct($tabItems, $nombreP,$resultat,$typeAff) {
        parent::__construct();
        $this->liste = $tabItems;
        $this->typeAff = $typeAff;
        $this->nombreParticipants = $nombreP;
        $this->resultat = $resultat;
        $this->urlDemandeListe = self::getApp()->urlFor('demander_une_liste');
    }

    private function demandeUneListe(){
        if (isset($_POST['demandeUneListe'])){
            $token = $_POST['demandeUneListe'];
            $request = Liste::select('no')->where('token', '=' , $token)->first();
            if ($request != null){
                self::getApp()->redirect(self::getApp()->urlFor('afficher_une_liste',['token' => $token]));
            }else{
                $url = self::getApp()->urlFor('demander_une_liste');
            }
        }else{
            $url = self::getApp()->urlFor('demander_une_liste');
        }
        $listesAffich = "";
        foreach ($this->liste as $value){
            $token = $value->token;
            $lien = self::getApp()->urlFor('afficher_une_liste',['token' => $token]);
            $listesAffich = $listesAffich . "\n" . "
            <div class='bg-light shadow'>
                                    <a href=\"$lien\" class='text-black-50'>
                                    <h3 class='text-liste-main'>$value->titre</h3>
                                    </a>
            </div></br> ";
        }
        $res = "
            </br>
            <h1>Veuillez entrer le Token de la liste voulue :</h1>
            </br>
            <form id='formulaireListe' method='POST' action=$url>
                <input type='text' name='demandeUneListe' placeholder='Token De La Liste'>
                <button type='submit' name='valider' value='valid_reserverItem'>Valider</button>
            </form>
            </br>
            Voici les listes publiques : </br></br>
            $listesAffich
            ";
        return $res;
    }
    private function affichageUneListe(){
        $titre =  $this->liste->titre;
        $lien = self::getApp()->urlFor('afficher_items_dune_liste', ['no' => $this->liste->no]);
        if(isset($_POST['demandeModifListe'])){
            $tokenModif = $_POST['demandeModifListe'];
            $request = Liste::select('no')->where('tokenModif','=',$tokenModif)->first();
            if($request != null){
                self::getApp()->redirect(self::getApp()->urlFor('modifier_une_liste',['token'=>$tokenModif]));
            }else{
                $url = self::getApp()->urlFor('afficher_une_liste_post',['token'=>$this->liste->token]);
            }
        }else{
            $url = self::getApp()->urlFor('afficher_une_liste_post',['token'=>$this->liste->token]);
        }
        $url2 = self::getApp()->urlFor('afficher_une_liste_post',['token'=>$this->liste->token]);
        $value = $this->liste;
        $res = <<<END
                </br>
                <a href="$lien" class='text-black-50'>
                    <div class='affichageListe'>
                        $titre
                    </div>
                </a></br>
                $value->messages
                </br></br>
                <p>En rentrant le Token de modification de cette liste vous pourrez modifier ses informations générales ainsi qu'ajouter un item.</p>
                <form id='formulaireModifListe' method='POST' action=$url>
                    <input type='text' name='demandeModifListe' placeholder='Token de modification de la liste'>
                    <button type="submit" class="btn btn-primary">Valider</button>
                </form>
                </br>
                <h5>Nombre des participants à la liste</h5>
                </br>
                <div>
                <p>$this->nombreParticipants</p>
                </div>
                </br>
                </br>
                <h5>Noms des participants à la liste</h5>
                </br>
                <div>
                    $this->resultat
                </div>
                </br>
                <form class="test" method="POST" action=$url2>           
                    <textarea class="textareaAffich" id="textareaAffich" name="une_liste_message"></textarea>
                    </br>
                    <button type="submit" name="singlebutton" class="btn btn-primary">Valider</button>
                </form>
                </br>
END;
        return $res;
    }
    /**
     * Affiche toutes les listes dans un tableau
     * @return string
     */
    private function affichageToutListe() {
        $res = '';
        foreach ($this->liste as $value){
            $lien = self::getApp()->urlFor('afficher_items_dune_liste', ['no' => $value->no]);
            $res = $res . "
                                <a href=\"$lien\" class='text-black-50'>
                                    <div class='affichageListe'>
                                    $value->titre  
                                    </div>
                                </a><br><br>
                           ";
        }
        $res = $res . '';
        return "<h1> Liste des Listes : </h1></br> $res";
    }

    /**
     * Affiche tous les items présents dans une liste, ainsi que leur image et leur description
     * @return string
     */
    private function affichageItemsDeListe(){
        $res ='<section>';
        foreach ($this->liste as $value){
            $lien = self::getApp()->urlFor('afficher_item_id', ['id' => $value->id]);
            $res = $res . "
                                    <div class='bg-light shadow'>
                                    <a href=\"$lien\" class='text-black-50'>
                                    <h3 class='text-liste-main'>$value->nom</h3>
                                    </a>
                                    <p>$value->descr</p>
                                    </div>
                                <br><br>
                           ";
        }
        $res = $res . "</section>";
        return "<h1> Les items de la liste sont : </h1><br> $res";
    }

    /**
     * fonction utilisée pour le rendu des vues
     */
    public function render(){
        switch ($this->typeAff){
            //cas où l'on veut afficher toutes les listes
            case 'ALL_LISTE' : {
                $content = $this->affichageToutListe();
                break;
            }
            //cas où l'on veut afficher les items d'une liste
            case 'ITEM_LISTE' : {
                $content = $this->affichageItemsDeListe();
                break;
            }
            case 'AFFICHER_UNE_LISTE' : {
                $content = $this->affichageUneListe();
                break;
            }
            case 'DEMANDER_UNE_LISTE' : {
                $content = $this->demandeUneListe();
                break;
            }
            case 'MODIFIER_UNE_LISTE' : {
                $content = $this->accederModifierListe();
                break;
            }
        }

        $menu = self::getMenu();
        $footer = self::getFooter();
        $html = "
              $menu
                <div class=\"container h-100\">
                    <div class=\"row h-100 align-items-center\">
                           <div class=\"col-12 text-center\">
                                $content
                           </div>
                    </div>
                </div>
              $footer";




        echo $html;
    }
}