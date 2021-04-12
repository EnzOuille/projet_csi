<?php


namespace projet\vue;


class VueCreerLotGest extends VuePrincipaleGest
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
            <legend>Création de lot</legend>
            
            <!-- Text input-->
            <div class=\"form-group\">
              <label class=\"col-md-4 control-label\" for=\"description\">Description</label>  
              <div class=\"col-md-4\">
              <input id=\"description\" name=\"description\" type=\"text\" placeholder=\"Description du produit\" class=\"form-control input-md\" required=\"\">
                
              </div>
            </div>
            
            <!-- Text input-->
            <div class=\"form-group\">
              <label class=\"col-md-4 control-label\" for=\"prixestime\">Prix estimé</label>  
              <div class=\"col-md-4\">
              <input id=\"prixestime\" name=\"prixestime\" type=\"text\" placeholder=\"Prix estimé du lot\" class=\"form-control input-md\" required=\"\">
                
              </div>
            </div>
            
            <!-- Text input-->
            <div class=\"form-group\">
              <label class=\"col-md-4 control-label\" for=\"prixminimal\">Prix minimal</label>  
              <div class=\"col-md-4\">
              <input id=\"prixminimal\" name=\"prixminimal\" type=\"text\" placeholder=\"Prix minimal du lot\" class=\"form-control input-md\" required=\"\">
                
              </div>
            </div>
            
            <!-- Text input-->
            <div class=\"form-group\">
              <label class=\"col-md-4 control-label\" for=\"datedebut\">Date début</label>  
              <div class=\"col-md-4\">
              <input id=\"datedebut\" name=\"datedebut\" type=\"text\" placeholder=\"Date de début du lot\" class=\"form-control input-md\" required=\"\">
              <span class=\"help-block\">jj/mm/yyyy</span>  
              </div>
            </div>
            
            <!-- Text input-->
            <div class=\"form-group\">
              <label class=\"col-md-4 control-label\" for=\"datefin\">Date fin</label>  
              <div class=\"col-md-4\">
              <input id=\"datefin\" name=\"datefin\" type=\"text\" placeholder=\"Date de fin du lot\" class=\"form-control input-md\" required=\"\">
              <span class=\"help-block\">jj/mm/yyyy</span>  
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