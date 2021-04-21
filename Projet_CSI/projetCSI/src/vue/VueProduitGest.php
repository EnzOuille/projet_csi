<?php


namespace projet\vue;


class VueProduitGest extends VuePrincipaleGest
{
    private $produits;

    public function __construct($produits)
    {
        parent::__construct();
        $this->produits = $produits;
        $value = $this->produits;
    }

    /*
    * Permet l'affichage de l'item en question selon les différents changements
    */
    private function afficherProduits()
    {
        $res = '';
        foreach ($this->produits as $produit) {
            $res .= $produit['idproduit'] . ' - ' . $produit['description'] . ' - ' . $produit['type'] . '<br><br>';
        }
        return $res;
    }

    public function render()
    {
        $menu = self::getMenu();
        $footer = self::getFooter();
        $content = self::afficherProduits();
        $html = "
            $menu
            <div class=\"container h - 100\">
                <div class=\"row h - 100 align - items - center\">
                   <div class=\"col - 12 text - center\">
                    <br>
                        $content
                   </div>
                </div>
            </div>
            $footer
        ";
        echo $html;
    }
}