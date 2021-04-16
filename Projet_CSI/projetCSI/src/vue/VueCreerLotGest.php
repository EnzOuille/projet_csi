<?php


namespace projet\vue;


class VueCreerLotGest extends VuePrincipaleGest
{
    /**
     * @var string
     */
    private $url_post;

    public function __construct()
    {
        parent::__construct();
        $this->url_post = self::getApp()->urlFor('creer_lots_post');
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
            <legend>Création de lot</legend>
            
            <!-- Text input-->
            <div class="form-group">
              <label class="col-md-4 control-label" for="description">Description</label>  
              <div class="col-md-4">
              <input id="description" name="creerlot_description" type="text" placeholder="Description du lot" class="form-control input-md" required="">
                
              </div>
            </div>
            
            <!-- Text input-->
            <div class="form-group">
              <label class="col-md-4 control-label" for="prixestime">Prix estimé</label>  
              <div class="col-md-4">
              <input id="prixestime" name="creerlot_prixestime" type="text" placeholder="Prix estimé du lot" class="form-control input-md" required="">
                
              </div>
            </div>
            
            <!-- Text input-->
            <div class="form-group">
              <label class="col-md-4 control-label" for="prixminimal">Prix minimal</label>  
              <div class="col-md-4">
              <input id="prixminimal" name="creerlot_prixminimal" type="text" placeholder="Prix minimal du lot" class="form-control input-md" required="">
                
              </div>
            </div>
            
            <!-- Text input-->
            <div class="form-group">
              <label class="col-md-4 control-label" for="datedebut">Date début</label>  
              <div class="col-md-4">
              <input id="datedebut" name="creerlot_datedebut" type="text" placeholder="Date de début du lot" class="form-control input-md" required="">
              <span class="help-block">yyyy-mm-jj</span>  
              </div>
            </div>
            
            <!-- Text input-->
            <div class="form-group">
              <label class="col-md-4 control-label" for="datefin">Date fin</label>  
              <div class="col-md-4">
              <input id="datefin" name="creerlot_datefin" type="text" placeholder="Date de fin du lot" class="form-control input-md" required="">
              <span class="help-block">yyyy-mm-jj</span>  
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