<?php

namespace projet\vue;

class VueCreerListeGest extends VuePrincipaleGest {


    private $urlListeCree;
    private $text;

    public function __construct($txt) {
        $this->text = $txt;
        parent::__construct();
        $this->urlListeCree = self::getApp()->urlFor('liste_cree');
    }
    /*
    * fonction permettant de traiter le cas lorsque la date entrée par l'utilisateur est inférieure à la date courante
    */
    private function erreurDate() {
        if ($this->text == "erreurDate") {
            echo <<<END
            <div class="alert alert-danger" role="alert">
  Insertion impossible car date enregistrée inférieur à la date courante.
</div>
END;
        }
    }

    public function render() {
        $menu = self::getMenu();
        $foot = self::getFooter();
        $html = <<<END
                $menu
                <br>
                <div class="container h-100">
                    <div class="row h-100 align-items-center">
                           <div class="col-12 text-center">
                           <form id="f1" method="post" action="$this->urlListeCree" enctype="multipart/form-data">
                           <div class="form-row">
                               <div class="col-md-4 mb-3">
                               <label for="validationServer01">Titre</label>
                               <input type="text" class="form-control is-valid" id="validationServer01" name="titre" placeHolder="Exemple : Pour fêter le bac !" required>
                               <div class="valid-feedback">
                               </div>
                               </div>
                           </div>
                           <div class="form-group">
                               <label for="exampleFormControlTextarea1">Description</label>
                               <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" name="description" placeHolder="Exemple : une belle description"required></textarea>
                           </div>
                           <div class="form-row">
                           <div class="col-md-4 mb-3">
                           <label for="validationServer01">Date d'expiration</label>
                           <input type="date" class="form-control is-valid" id="validationServer01" name="expiration" required>
                           <div class="valid-feedback">
                           </div>
                           </div>
                       </div>
                        <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="liste_publique" id="customCheck1">
                        <label class="custom-control-label" for="customCheck1">Rendre la liste publique</label>
                        </div>
                        <br>
                           <div class="form-group">
                               <div class="form-check">
                               <input class="form-check-input is-invalid" type="checkbox" value="" id="invalidCheck3" required>
                               <label class="form-check-label" for="invalidCheck3">
                                   Accepter les termes et conditions
                               </label>
                               <div class="invalid-feedback">
                               Vous devez accepter avant de soumettre.
                               </div>
                               </div>
                           </div>
                           <button class="btn btn-primary" type="submit" name="creer">Créer</button>
                           </form>
                           </div>
                    </div>
                </div>
                $foot
END;
        echo $html . "</br>";
        $this->erreurDate();
    }
}