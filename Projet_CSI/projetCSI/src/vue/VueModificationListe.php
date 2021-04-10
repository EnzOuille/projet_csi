<?php
namespace projet\vue;

class   VueModificationListe extends VuePrincipale{

    private $liste,$lienAffichageListe, $listItemAfficher;
    public function __construct($tabItems)
    {
        parent::__construct();
        $this->listItemAfficher = "";
        $this->liste = $tabItems;
        $value = $this->liste;
        if($tabItems != null){
            $this->lienAffichageListe = self::getApp()->urlFor('afficher_une_liste_post',['token'=> $value->token]);
        }
    }

    public function modificationListe(){
        $items = $this->listItemAfficher;
        if(isset($_POST['ajoutItem_Valider'])){
            $txtAjout = "<div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
  <strong>Trop bien !</strong> Votre item a été ajouté à votre liste !
  <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
    <span aria-hidden=\"true\">&times;</span>
  </button>
</div>";
        } else {
            $txtAjout = "";
        }
        if(isset($_POST['modif_valider'])){
            $txtModif = "<div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
  <strong>Trop bien !</strong> Votre liste a été modifiée !
  <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
    <span aria-hidden=\"true\">&times;</span>
  </button>
</div>";
        } else {
            $txtModif = '';
        }
        $value = $this->liste;
        if($value !=null){
            $valeurMessage = $value->description;
            $tokenModif = $value->tokenModif;
            $titre = $value->titre;
            $description = $value->description;
        }else{
            $tokenModif = '';
            $valeurMessage = '';
            $titre = '';
            $description = '';
        }
        $lien2 = self::getApp()->urlFor('ajouter_item_reussi', ['tokenModif' => $tokenModif]);
        $url = self::getApp()->urlFor('modification_une_liste',['tokenModif'=>$tokenModif]);
        $url2 = self::getApp()->urlFor('demander_une_liste_ap_supp', ['token'=>$tokenModif]);
        $res = "
                <form class=\"form-horizontal\" method='post' action=$url>
<fieldset>
<!-- Form Name -->
<legend>Modification d'une liste</legend>
$txtModif
<!-- Textarea -->

<div class=\"container\">
  <div class=\"row\">
    <div class=\"col\">
        <div class=\"form - group\">
  <label class=\"col - md - 4 control - label\" for=\"textarea\">Titre *</label>
  <div class=\"col - md - 4\">                     
    <textarea class=\"form-control\" required id=\"textarea\" name=\"modifListe_titre\">$titre</textarea>
  </div>
</div>

<!-- Textarea -->
<div class=\"form - group\">
  <label class=\"col - md - 4 control - label\"  for=\"textarea\">Description : *</label>
  <div class=\"col - md - 4\">                     
    <textarea class=\"form-control\" required id=\"textarea\" name=\"modifListe_description\">$description</textarea>
    <BR>
    <button class='btn btn-primary' type='submit' name='modif_valider'>Valider</button>
  </div>
</div>
</fieldset>
</form>
</br>
    </div>
    <div class=\"col\">
      <legend>
                                    Ajout d'items !
                                </legend>
    $txtAjout
                                
                                <form id=\"myForm\" method=\"post\" action=\"$lien2\" >
	<br>Nom *<br><input class='form-control' name=\"nom\" id=\"text1\" type=\"text\" required placeholder=\"Item personnalisé\" >
	<br>Description *<br><textarea class='form-control' name=\"desc\" id=\"textarea2\" cols=\"18\" rows=\"5\" required placeholder=\"Une rapide description\" ></textarea>
	<br>Prix *<br><input class='form-control' name=\"prix\" id=\"text3\" type=\"number\" required placeholder=\"15€\" >
	<br>Lien vers cet item<br><input class='form-control' name=\"url\" id=\"url4\" type=\"url\" >
	<br><br><input class='btn btn-primary' name=\"ajoutItem_Valider\" type=\"submit\" value=\"Valider\" >
</form>

    </div>
    <div class='col'>
    <legend>Contenu de la liste !</legend>
        $items
    </div>
    
    <div class='col'>
        <form class=\"form-horizontal\" method=\"post\" action=\"$url2\">
            <button class='btn btn-danger' type='submit' name='modifItem_valider'>Supprimer la liste !</button>
        </form>
    </div>
  </div>
</div>






<a href='$this->lienAffichageListe'>Retour à l'affichage de la liste</a>
        ";
        return $res;
    }

    public function afficherItems($listItem){
        foreach ($listItem as $value){
            $lien = self::getApp()->urlFor('modifier_item_id', ['id' => $value->id]);
            $this->listItemAfficher .=  "
                                    <a href=\"$lien\" class='text-black-50'>
                                    <h3 class='text-liste-main'>$value->nom</h3>
                                    </a>
                                    <p>$value->descr</p>
                                <br><br>
                           ";
        }
    }


    public function render(){
        $menu = self::getMenu();
        $footer = self::getFooter();
        $content = $this->modificationListe();
        $html = "
                $menu
                <div class=\"container h - 100\">
                    <div class=\"row h - 100 align - items - center\">
                           <div class=\"col - 12 text - center\">
                                $content
                           </div>
                    </div>
                </div>
                $footer";
        echo $html;
    }
}