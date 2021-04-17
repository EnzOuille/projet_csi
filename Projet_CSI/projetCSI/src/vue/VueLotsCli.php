<?php


namespace projet\vue;


class VueLotsCli extends VuePrincipaleCli
{

    private $lots,$lienCreerPropal,$id;

    public function __construct($lots,$id){
        parent::__construct();
        $this->id = $id;
        $this->lots = $lots;
        $this->lienCreerPropal = self::getApp()->urlFor('creer_affichage_proposition');
    }


    public function render(){
        $menu = self::getMenu();
        $footer = self::getFooter();
        $id = $this->id;
        $html = <<<END
            $menu
            <form class="form-horizontal" method="post">
            <fieldset>

            <!-- Form Name -->
            <legend>Voici tout les lots en vente</legend>
               
             $this->lots
            <!-- Button -->
            
            </fieldset>
            </form>
            $footer
        END;
        echo $html;
    }
}