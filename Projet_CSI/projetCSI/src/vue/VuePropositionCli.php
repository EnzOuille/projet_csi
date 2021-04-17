<?php


namespace projet\vue;


class VuePropositionCli extends VuePrincipaleCli
{
    private $propals;

    public function __construct($propals)
    {
        parent::__construct();
        $this->propals = $propals;
    }

    private function afficherPropals()
    {
        $res = '';
        foreach ($this->propals as $propal) {
            $res = <<<END
              <div class="form-group">
              <label class="col-md-4 control-label" for="idlot$propal[idlot]">ID Lot : $propal[idlot] - $propal[montant] - Date : $propal[dateproposition]</label>
              <div class="col-md-4">    
                <a id="singlelink" href="/projet_csi/Projet_CSI/projetCSI/client/$propal[idclient]/propals?id=$propal[idclient]&lot=$propal[idlot]" class="btn btn-primary">Modifier Montant</a>
              </div>
              </div>    
            END;
        }
        return $res;
    }

    public function render()
    {
        $menu = self::getMenu();
        $footer = self::getFooter();
        $content = $this->afficherPropals();
        $html = <<<END
            $menu
            <form class="form-horizontal" method="post" action="">
            <fieldset>
            
            <!-- Form Name -->
            <legend>Voici les propositions du client</legend>
            
            <!-- Text input-->
            $content
            
            </fieldset>
            </form>

            $footer
        END;
        echo $html;
    }
}