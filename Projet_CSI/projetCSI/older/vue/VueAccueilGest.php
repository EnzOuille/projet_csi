<?php


namespace projet\vue;


class VueAccueilGest extends VuePrincipaleGest
{

    public function render(){
        $menu = self::getMenu();
        $footer = self::getFooter();
        $html = "
$menu
<header class=\"masthead\">
  <div class=\"container h-100\">
    <div class=\"row h-100 align-items-center\">
      <div class=\"col-12 text-center\">
        <h1 style=\"color:white\" class=\"font-weight-light\">Bienvenue sur My Wish List !</h1>
        <p style=\"color:white\" class=\"lead\">Cliquez sur les boutons au dessus pour intéragir.</p>
      </div>
    </div>
  </div>
</header>


<section class=\"py-5\">
  <div class=\"container\">
    <h2 class=\"font-weight-light\">Auteurs</h2>
    <p>CISTERNINO Enzo - TONDON César</p>
  </div>
</section>
$footer
";

        echo $html;
    }
}