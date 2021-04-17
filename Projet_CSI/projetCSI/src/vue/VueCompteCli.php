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
        return '<h2> Information du compte client : '. $this->client[0]['idclient'] . '</h2>'
            . '<p> Appartient a : '.$this->client[0]['nom'] . ' ' . $this->client[0]['prenom'] . '<br>'
            . 'Email : ' . $this->client[0]['email'] . '<br>'
            . 'Solde : ' . $this->client[0]['solde'] . '<br>'
            . "Date d'inscription" . $this->client[0]['dateinscription'] . '</p>';
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