<?php


namespace projet\vue;


class VueSupprimerLot extends VuePrincipaleGest
{
    private $lots,$lienSupPost;

    public function __construct($lots){
        parent::__construct();
        $this->lots = $lots;
        $this->lienSupPost = self::getApp()->urlFor('supprimer_lot_post');
    }


    public function render(){
        $menu = self::getMenu();
        $footer = self::getFooter();
        $html = <<<END
            $menu
            <form class="form-horizontal" method="post" action="$this->lienSupPost">
            <fieldset>

            <!-- Form Name -->
            <legend>Choissisez le lot à supprimer</legend>
            <div class="form-group">
                <label class="col-md-4 control-label" for="composition_idlot">Choissez le lot à construire</label>
            <div class="col-md-4">
                <select id="composition_idlot" name="supprimer_idlot" class="form-control">
             $this->lots
            </select>
            </div>
            </div>
            <div class="form-group">
             <label class="col-md-4 control-label" for="submit"></label>
            <div class="col-md-4">
               <button id="submit" name="submit" class="btn btn-primary">Supprimer le lot</button>
              </div>
            </div>
            </fieldset>
            </form>
            $footer
        END;
        echo $html;
    }
}