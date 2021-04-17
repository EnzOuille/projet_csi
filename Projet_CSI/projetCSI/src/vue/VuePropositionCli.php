<?php


namespace projet\vue;


class VuePropositionCli extends VuePrincipaleCli
{
    private $propals;

    public function __construct($propals)
    {
        parent::__construct();
        $this->propals = $propals;
        $value = $this->propals;
        $this->lienPost = self::getApp()->urlFor('creer_affichage_proposition');
    }

    private function afficherPropals()
    {
        $res = '';
        foreach ($this->propals as $propal) {
            $res .= $propal['idproposition'] . ' - ' . $propal['montant'] . ' - ' . $propal['dateproposition'] . ' - ' . $propal['etatpropal'] . ' - ' . $propal['idclient'] . ' - ' . $propal['idlot'] . ' - ' . $propal['datevalidation'] . '<br>';
        }
        return $res;
    }

    public function render()
    {
        $menu = self::getMenu();
        $footer = self::getFooter();
        $content = self::afficherPropals();
        $html = <<<END
            $menu
            <form class="form-horizontal" method="post" action="">
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
            
            </fieldset>
            </form>

            $footer
        END;
        echo $html;
    }
}