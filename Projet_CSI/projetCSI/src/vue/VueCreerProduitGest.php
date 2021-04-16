<?php


namespace projet\vue;


use projet\vue\VuePrincipaleGest;

class VueCreerProduitGest extends VuePrincipaleGest
{
    private $url_accueil;

    public function __construct()
    {
        parent::__construct();
        $this->url_post = self::getApp()->urlFor('creer_produits_post');
    }

    public function render()
    {
        $menu = self::getMenu();
        $footer = self::getFooter();
        echo $this->url_accueil;
            $html = <<<END
            $menu
            <form class="form-horizontal" action="$this->url_accueil" method="post">
            <fieldset>
            
            <!-- Form Name -->
            <legend>Création de produit</legend>
            
            <!-- Text input-->
            <div class="form-group">
              <label class="col-md-4 control-label" for="description">Description</label>  
              <div class="col-md-4">
              <input id="description" name="creerProduit_description" type="text" placeholder="Description du produit" class="form-control input-md" required="">
                
              </div>
            </div>
            
            <!-- Text input-->
            <div class="form-group">
              <label class="col-md-4 control-label" for="type">Type</label>  
              <div class="col-md-4">
              <input id="type" name="creerProduit_type" type="text" placeholder="Type du produit" class="form-control input-md" required="">
                
              </div>
            </div>
            
            <!-- Button -->
            <div class="form-group">
              <label class="col-md-4 control-label" for="submit"></label>
              <div class="col-md-4">
                <button id="submit" name="submit" class="btn btn-primary">Créer</button>
              </div>
            </div>
            </fieldset>
            </form>
            $footer
        END;
        echo $html;
        }
}