<?php


namespace projet\vue;


class VueModificationItemGest extends VuePrincipaleGest
{
    private $item;
    public function __construct($item)
    {
        parent::__construct();
        $this->item=$item;
    }

    public function render(){
        $menu = self::getMenu();
        $footer = self::getFooter();
        $content = $this->modificationItem();
        $html = "
                $menu
                <div class=\"container h - 100\">
                    <div class=\"row h - 100 align - items - center\">
                           <div class=\"col - 12 text - center\">
                                $content
                           </div>
                    </div>
                </div>
                $footer";
        echo $html;
    }

    private function modificationItem()
    {
        $value = $this->item;
        if($value!=null) {
            $titre = $value->nom;
            $description = $value->descr;
            $prix = $value->tarif;
            $url = self::getApp()->urlFor('modifier_item_ap_formulaire', ['id'=>$value->id]);
            $url2 = self::getApp()->urlFor('supprimer_item', ['id'=>$value->id]);
        }

        $html = <<<END
<form class="form-horizontal" method='post' action="$url">
<fieldset>
<!-- Form Name -->
<legend>Modification de l'item</legend>

<!-- Textarea -->

<div class="container">
  <div class="row">
    <div class="col">
        <div class="form - group">
          <label class="col - md - 4 control - label" for="textarea">Nom *</label>
          <div class="col - md - 4">                     
            <textarea class="form-control" required id="textarea" name="modifItem_titre">$titre</textarea>
          </div>    
        </div>

<!-- Textarea -->
<div class="form - group">
  <label class="col - md - 4 control - label"  for="textarea">Description : *</label>
  <div class="col - md - 4">                     
    <textarea class="form-control" required id="textarea" name="modifItem_desc">$description</textarea>
    <BR>
   </div>
</div>
    <div class="form - group">
          <label class="col - md - 4 control - label" for="textarea">Prix *</label>
          <div class="col - md - 4">                     
            <input class="form-control" required id="textarea" type="number" value=$prix name="modifItem_prix">
          </div>    
        </div>
        <br>
    <button class='btn btn-primary' type='submit' name='modifItem_valider'>Valider</button>
  </div>
</div>
</fieldset>
</form>
<br>
    <form class="form-horizontal" method="post" action="$url2">
        <button class='btn btn-danger' type='submit' name='modifItem_valider'>Supprimer l'item</button>
    </form>

END;
return $html;
    }


}