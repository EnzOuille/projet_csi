<?php
namespace projet\controller;

use Illuminate\Database\Eloquent\Model;
use projet\modele\AppartientA;
use projet\modele\Lot;
use projet\modele\Produit;
use projet\vue\VueCompositionGest;
use Slim\Slim;
use projet\vue\VueCreerLotGest;

class LotController
{
    /*
    * Créer un lot
    */
    public static function afficher_creer_lot()
    {
        $vue = new VueCreerLotGest();
        $vue->render();
    }

    public static function creerLot(){
        $app = Slim::getInstance();
        $url = $app->urlFor('page_index_gest');
        $lot = new Lot();
        $lot->description = $_POST['creerlot_description'];
        $lot->prixestime = $_POST['creerlot_prixestime'];
        $lot->prixminimal = $_POST['creerlot_prixminimal'];
        $lot->datedebut = $_POST['creerlot_datedebut'];
        $lot->datefin = $_POST['creerlot_datefin'];
        $lot->save();
        $app->redirect($url);
    }

    public static function creerComposition(){
        $ids_Lot = Lot::select('idlot')->whereNotIn('idlot',AppartientA::select('idlot')->groupby('idlot'))->get()->all();
        $options = "";
        foreach ( $ids_Lot as $lot ){
                $options .= <<<END
                    <option value="$lot[idlot]">IdLot = $lot[idlot]</option>
                END;
        }

        $prods = Produit::get()->all();
        $produits = "";
        foreach ( $prods as $prod){
            $produits .= <<<END
            <div class="form-group">
            <label class="col-md-4 control-label" for="composition_$prod[idproduit]">$prod[description]</label>
            <div class="col-md-4">
                <select id="composition_idlot" name="composition_$prod[idproduit]" class="form-control">
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
            </div>
            END;
        }
        $vue = new VueCompositionGest($options,$produits);
        $vue->render();
    }

    public static function insererComposition(){
        $prods = Produit::select('idproduit')->get()->all();
        if (isset($_POST['composition_idlot'])){
            $idLot = $_POST['composition_idlot'];
        }
        foreach ( $prods as $prod){
            if (isset($_POST['composition_' . $prod['idproduit']])){
                if ($_POST['composition_' . $prod['idproduit']] > 0){
                    echo $_POST['composition_' . $prod['idproduit']];
                    $comp = new AppartientA();
                    $comp->idproduit = (int)$prod['idproduit'];
                    $comp->quantite = $_POST['composition_' . $prod['idproduit']];
                    $comp->idlot = (int)$idLot;
                    $comp->save();
                }
            }
        }
        $app = Slim::getInstance();
        $url = $app->urlFor('page_index_gest');
        $app->redirect($url);
    }
}