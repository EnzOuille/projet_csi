<?php


namespace projet\vue;


use projet\vue\VuePrincipaleCli;

class VueCompteCli extends VuePrincipaleCli
{
    private $client;

    public function __construct($client)
    {
        parent::__construct();
        $this->client = $client;
    }

    public function afficherInformation() {
        return '<h2 class="col-md-5 control-label"> Information du compte client : '. $this->client[0]['idclient'] . '</h2>'
            . '<p class="col-md-4 control-label"> Appartient a : '.$this->client[0]['nom'] . ' ' . $this->client[0]['prenom'] . '<br><br>'
            . 'Email : ' . $this->client[0]['email'] . '<br><br>'
            . "Date d'inscription" . $this->client[0]['dateinscription'] . '</p>'
            . '<form class="form-horizontal" action="'. $this->client[0]['idclient'] . '" method="post">
                <fieldset>
                <!-- Appended Input-->
                <div class="form-group">
                  <label class="col-md-4 control-label" for="appendedtext">Solde</label>
                  <div class="col-md-4">
                    <div class="input-group">
                      <input id="nouveausolde" name="nouveausolde" class="form-control" placeholder="' . $this->client[0]['solde'] . '" type="text" required="">
                      <button id="boutonmodifiersolde" name="boutonmodifiersolde" class="btn btn-primary">Modifier</button>
                    </div>
                  </div>
                </div>
                </fieldset>
                </form>
                ';
    }

    public function render()
    {
        $menu = self::getMenu();
        $footer = self::getFooter();
        $content = self::afficherInformation();
        $html = <<<END
            $menu
            $content
            $footer
        END;
        echo $html;
    }
}