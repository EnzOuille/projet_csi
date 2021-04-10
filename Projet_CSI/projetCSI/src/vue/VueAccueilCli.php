<?php


namespace projet\vue;


class VueAccueilCli extends VuePrincipaleCli
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
        <h1 style=\"color:white\" class=\"font-weight-light\">Bienvenue sur notre projetCSI !</h1>
        <p style=\"color:white\" class=\"lead\">Cliquez sur les boutons au dessus pour intéragir.</p>
      </div>
    </div>
  </div>
</header>


<section class=\"py-5\">
  <div class=\"container\">
    <h2 class=\"font-weight-light\">Auteurs</h2>
    <p>CISTERNINO Enzo - SOUSA Alexandre</p>
  </div>
</section>
$footer
";

        echo $html;
    }
}