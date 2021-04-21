<?php


namespace projet\vue;


class VueMessageGest extends VuePrincipaleGest
{
    private $message;

    public function __construct($message)
    {
        parent::__construct();
        $this->message = $message;
    }

    public function render(){
        $menu = self::getMenu();
        $footer = self::getFooter();
        $html = "
            $menu
            <div class=\"container h - 100\">
                <div class=\"row h - 100 align - items - center\">
                   <div class=\"col - 12 text - center\">
                    <br>
                        $this->message
                   </div>
                </div>
            </div>
            $footer
        ";
        echo $html;
    }
}