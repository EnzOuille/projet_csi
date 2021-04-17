<?php


namespace projet\vue;


use projet\controller\LotController;
use projet\modele\Lot;

class VueCompositionGest extends VuePrincipaleGest
{

    private $url_post, $options, $produits;

    public function __construct($options,$produits)
    {
        parent::__construct();
        $this->url_post = self::getApp()->urlFor('creer_composition_post');
        $this->options = $options;
        $this->produits = $produits;
    }

    public function render()
    {
        $menu = self::getMenu();
        $footer = self::getFooter();
        $html = <<<END
        $menu
        <form class="form-horizontal" action="$this->url_post" method="post">
        <fieldset>
        
        <!-- Form Name -->
        <legend>Composition d'un lot</legend>
        
        <!-- Select Basic -->
        <div class="form-group">
          <label class="col-md-4 control-label" for="composition_idlot">Choissez le lot à construire</label>
          <div class="col-md-4">
            <select id="composition_idlot" name="composition_idlot" class="form-control">
              $this->options
            </select>
          </div>
        </div>
        
        $this->produits
        
        <div class="form-group">
          <label class="col-md-4 control-label" for="submit"></label>
          <div class="col-md-4">
            <button id="submit" name="submit" class="btn btn-primary">Créer la composition</button>
          </div>
        </div>
        
        </fieldset>
        </form>
        $footer
        END;
        echo $html;
    }
}