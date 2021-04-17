<?php


namespace projet\vue;


class VueCreerPropositionCli extends VuePrincipaleCli
{

    private $id,$lot,$urlPost;

    public function __construct()
    {
        parent::__construct();
        $this->id = $_GET['id'];
        $this->lot = $_GET['lot'];
        $this->urlPost = self::getApp()->urlFor('creer_proposition');
    }

    public function render()
    {
        $menu = self::getMenu();
        $footer = self::getFooter();
        $html = <<<END
            $menu
            <form class="form-horizontal" method="post" action="$this->urlPost?id=$this->id&lot=$this->lot">
            <fieldset>
            
            <!-- Form Name -->
            <legend>Faire une proposition sur le lot</legend>
            
            <!-- Text input-->
            <div class="form-group">
              <div class="col-md-4">
                              ID Client : $_GET[id] <br>
              ID Lot : $_GET[lot] <br>
              </div>
              <label class="col-md-4 control-label" for="textinput">Montant de la proposition</label>  
              <div class="col-md-4">
              <input id="textinput" name="montant_propal" type="text" placeholder="500" class="form-control input-md">
              </div>
            </div>
            
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