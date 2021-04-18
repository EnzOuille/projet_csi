<?php


namespace projet\vue;


use projet\vue\VuePrincipaleCli;

class VueCompteCli extends VuePrincipaleCli
{
    private $client, $vente;

    public function __construct($client, $vente)
    {
        parent::__construct();
        $this->client = $client;
        $this->vente = $vente;
    }

    public function afficherInformation() {
        return '<h2 class="col-md-5 control-label"> Information du compte client : '. $this->client['idclient'] . '</h2>'
            . '<p class="col-md-4 control-label"> Appartient a : '.$this->client['nom'] . ' ' . $this->client['prenom'] . '<br><br>'
            . 'Email : ' . $this->client['email'] . '<br><br>'
            . "Date d'inscription" . $this->client['dateinscription'] . '</p>'
            . '<form class="form-horizontal" action="'. $this->client['idclient'] . '" method="post">
                <fieldset>
                <!-- Appended Input-->
                <div class="form-group">
                  <label class="col-md-4 control-label" for="appendedtext">Solde</label>
                  <div class="col-md-4">
                    <div class="input-group">
                      <input id="nouveausolde" name="nouveausolde" class="form-control" placeholder="' . $this->client['solde'] . '" type="text" required="">
                      <button id="boutonmodifiersolde" name="boutonmodifiersolde" class="btn btn-primary">Modifier</button>
                    </div>
                  </div>
                </div>
                </fieldset>
                </form>
                ';
    }

    public function afficherVentes() {
        $res = '';
        foreach ($this->vente as $vente) {
            if($vente['idclient'] == $this->client['idclient']) {
                $res .= 'Id vente : ' . $vente['idvente'] . ' - Montant : ' . $vente['montant'] . ' - Bénéfice : ' . $vente['benefice'] . ' - IdLot : ' . $vente['idlot'] . ' - IdClient du gagnant : ' . $vente['idclient']. '<br>';
            }
        }
        return $res;
    }

    public function render()
    {
        $menu = self::getMenu();
        $footer = self::getFooter();
        $informationCompte = self::afficherInformation();
        $ventes = self::afficherVentes();
        $html = <<<END
            $menu
            $informationCompte
            <h3 class="col-md-5 control-label">Les différentes ventes</h3>
            <div class="col-md-5 control-label">
                <div class=\"container h - 100\">
                    <div class=\"row h - 100 align - items - center\">
                       <div class=\"col - 12 text - center\">
                            $ventes
                       </div>
                    </div>
                </div>
            </div>
            
            $footer
        END;
        echo $html;
    }
}