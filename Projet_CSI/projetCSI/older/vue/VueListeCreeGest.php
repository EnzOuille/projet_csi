<?php
namespace projet\vue;
use projet\modele\Liste;
use projet\modele\Item;
use Illuminate\Database\Capsule\Manager as DB;
class VueListeCreeGest extends VuePrincipaleGest {
    
    private $url;
    private $liste;

    public function __construct($l) {
        parent::__construct();
        $this->liste = $l;
    }
    private function creationDeLaListe() {
      $tokenGenerated = $this->liste->token;
      $tokenModifGenerated = $this->liste->tokenModif;
      $titre = $this->liste->titre;
      $description = $this->liste->description;
      $expiration = $this->liste->expiration;
        echo <<<END
        <br>
        <div class="card" style="width: 18rem;">
        <div class="card-body">
          <h5 class="card-title">$titre</h5>
          <p class="card-text">$description</p>
          <p class="card-text"> <p class="mb-2 text-primary">Date d'expiration : </p>$expiration</p>
          <h6 class="card-subtitle mb-2 text-primary">Token pour partager la liste :</h6>
          <p class="card-text">$tokenGenerated</p>
          <h6 class="card-subtitle mb-2 text-primary">Token pour modifier la liste :</h6>
          <p class="card-text">$tokenModifGenerated</p>
        </div>
      </div>
 END;
    }

    public function render() {
        $menu = self::getMenu();
        $footer = self::getFooter();
        $html = <<<END
                $menu
                <div class="container h-100">
                    <div class="row h-100 align-items-center">
                            <div class="col-12 text-center">
                              
                           </div>
                    </div>
                </div>
                $footer
END ;
        echo $html;
        $this->creationDeLaListe();
    }
}