<?php


namespace projet\vue;


class VueCreerProduitGest extends VuePrincipaleGest
{
    public function __construct()
    {
        parent::__construct();
    }

    public function render()
    {
        $menu = self::getMenu();
        $footer = self::getFooter();
        $html = "
            $menu
            <form class=\"form-horizontal\">
            <fieldset>
            
            <!-- Form Name -->
            <legend>Création de produit</legend>
            
            <!-- Text input-->
            <div class=\"form-group\">
              <label class=\"col-md-4 control-label\" for=\"description\">Description</label>  
              <div class=\"col-md-4\">
              <input id=\"description\" name=\"description\" type=\"text\" placeholder=\"Description du produit\" class=\"form-control input-md\" required=\"\">
                
              </div>
            </div>
            
            <!-- Text input-->
            <div class=\"form-group\">
              <label class=\"col-md-4 control-label\" for=\"type\">Type</label>  
              <div class=\"col-md-4\">
              <input id=\"type\" name=\"type\" type=\"text\" placeholder=\"Type du produit\" class=\"form-control input-md\" required=\"\">
                
              </div>
            </div>
            
            <!-- Button -->
            <div class=\"form-group\">
              <label class=\"col-md-4 control-label\" for=\"submit\"></label>
              <div class=\"col-md-4\">
                <button id=\"submit\" name=\"submit\" class=\"btn btn-primary\">Créer</button>
              </div>
            </div>
            </fieldset>
            </form>
            $footer
        ";
        echo $html;
    }
}