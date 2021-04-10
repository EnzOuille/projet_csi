<?php
namespace projet\vue;

use projet\modele\Item;

class VueItemGest extends VuePrincipaleGest{

    private $produits;

    public function __construct($produits)
    {
        parent::__construct();
        $this->item = $item;
        $value = $this->item;
        $this->urlRevenirListe = self::getApp()->urlFor('afficher_item_id',['id' => $value->id]);
    }

    /*
    * Permet l'affichage de l'item en question selon les différents changements
    */
    private function affichageItemID()
    {
        $nom = $this->item->nom;
        $desc = $this->item->descr;
        $id = $this->item->id;
        $tarif = $this->item->tarif;
        $lienVersImage = self::getURLimages() . $this->item->img;
        $_SESSION['idItemActuel'] = $this->item->id;
        $url = self::getApp()->urlFor('afficher_item_id_post',['id'=>$id]);
        $urlAjoutImg = self::getApp()->urlFor('ajout_img');
        $valeurParticipant = $this->item->participant;
        $valeurMessage = $this->item->messageParticipant;
        $res = "   
                    <br>
                    <div class=\"card\" style=\"width: 18rem;\">
                    <span class='border border-primary'>
                        <form method='POST' action=$url>
                            <button type='submit' name='deleteImg'>Supprimer</button>
                            </form>
                            <form method='POST' action=$url>
                            <input type='text' name ='textImgWeb' placeHolder='url ici !'>
                            <button type='submit' name='imgWeb'>Ok</button>
                            </form>
                        <form method='POST' action=$url enctype='multipart/form-data'>
                            <input type='file' accept='test.png' name='img' >
                            <button type='submit' name='envoyer'>Envoyer</button>
                            </form>
                          <img src=\"$lienVersImage\" class=\"card-img-top\" alt=\"\">
                          <div class=\"card-body\">
                                <h5 class=\"card-title\">$nom</h5>
                                <p class=\"card-text\">$desc
                                </br>
                                Tarif : $tarif €</p>
                          </div>
                          <form id='formulaireItem' method='POST' action=$url>
                            <input type='text' name='afficherItem_participant' placeholder='Nom du Participant' value=$valeurParticipant>
                            <button type='submit' name='valider' value='valid_reserverItem'>Valider</button>
                            <textarea class='messageReservFormu' name='afficherItem_messageParticipant' placeholder='Un petit message ?'>$valeurMessage</textarea>
                          </form>
                    </span>
                    </div>";
        return $res;
    }

    public function render(){
        $menu = self::getMenu();
        $footer = self::getFooter();
        $content = self::affichageItemID();
        $html = "
            $menu
            <div class=\"container h - 100\">
                <div class=\"row h - 100 align - items - center\">
                   <div class=\"col - 12 text - center\">
                        $content
                   </div>
                </div>
            </div>
            $footer
        ";
        echo $html;
}
}