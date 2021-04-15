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
        $html = "
            $menu
            <div class=\"container h - 100\">
                <div class=\"row h - 100 align - items - center\">
                   <div class=\"col - 12 text - center\">
                        $content
                   </div>
                </div>
            </div>
            $footer
        ";
        echo $html;
    }
}