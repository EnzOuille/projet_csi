<?php


namespace projet\vue;


class VueGererLot extends VuePrincipaleGest
{
    private $lots,$lienGererPost;

    public function __construct($lots){
        parent::__construct();
        $this->lots = $lots;
        $this->lienGererPost = self::getApp()->urlFor('gerer_lot_post');
    }


    public function render(){
        $menu = self::getMenu();
        $footer = self::getFooter();
        $html = <<<END
            $menu
            <form class="form-horizontal" method="post" action="$this->lienGererPost">
            <fieldset>

            <!-- Form Name -->
            <legend>Choissisez le lot à Gerer</legend>
            <div class="form-group">
                <label class="col-md-4 control-label" for="composition_idlot">Appliquer le choix sur : </label>
            <div class="col-md-4">
                <select id="composition_idlot" name="gerer_idlot" class="form-control">
             $this->lots
            </select>
            </div>
            </div>
            <div class="form-group">
             <label class="col-md-4 control-label" for="submit"></label>
            <div class="col-md-4">
               <button id="supprimerlot" name="supprimerlot" class="btn btn-primary" value="Supprimer">Supprimer le lot</button>
               <button id="forcerlot" name="forcerlot" class="btn btn-success" value="Forcer">Forcer la vente du lot</button>
             </div>
            </div>
            </fieldset>
            </form>
            $footer
        END;
        echo $html;
    }
}