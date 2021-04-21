<?php
namespace projet\controller;

use Exception;
use Illuminate\Database\Capsule\Manager as DB1;
use Illuminate\Database\Eloquent\Model;
use projet\modele\AppartientA;
use projet\modele\Lot;
use projet\modele\Produit;
use projet\vue\VueCompositionGest;
use projet\vue\VueGererLot;
use projet\vue\VueLotsCli;
use projet\vue\VueMessageGest;
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

        try{
            $lot = new Lot();
            $lot->description = $_POST['creerlot_description'];
            $lot->prixestime = $_POST['creerlot_prixestime'];
            $lot->prixminimal = $_POST['creerlot_prixminimal'];
            $lot->datedebut = $_POST['creerlot_datedebut'];
            $lot->datefin = $_POST['creerlot_datefin'];
            $lot->save();
            $vue = new VueMessageGest('Le lot a bien été créé.<br><br>Cliquez sur les boutons ci-dessus pour naviguer sur le site');
            $vue->render();
        }catch (Exception $e){
            $vue = new VueMessageGest($e->getMessage());
            $vue->render();
        }
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

    public static function afficher_gererLot(){
        $lots = Lot::get()->all();
        $options = "";
        foreach ( $lots as $lot ){
            $options .= <<<END
                    <option value="$lot[idlot]">IdLot = $lot[idlot] Description : $lot[description]</option>
                END;
        }
        $vue = new VueGererLot($options);
        $vue -> render();
    }

    public static function gerer_lot(){
        var_dump($_POST);
        if(isset($_POST['supprimerlot'])) {
            self::supprimer_lot();
        } else {
            self::forcer_lot();
        }
    }

    public static function forcer_lot(){
        try{
            $file = parse_ini_file('src/conf/conf.ini');
            $db = new DB1();
            $db->addConnection($file);
            $db->setAsGlobal();
            $db->bootEloquent();
            $res = $db::select('CALL debut_vendre_lot(?)',[$_POST['gerer_idlot']]);
            $vue = new VueMessageGest('Le lot a bien été forcé à la vente.<br><br>Cliquez sur les boutons ci-dessus pour naviguer sur le site');
            $vue->render();
        }catch (Exception $e){
            $vue = new VueMessageGest($e->getMessage());
            $vue->render();
        }

    }

    public static function supprimer_lot(){
        try{
            $file = parse_ini_file('src/conf/conf.ini');
            $db = new DB1();
            $db->addConnection($file);
            $db->setAsGlobal();
            $db->bootEloquent();
            $res = $db::select('SELECT supprimer_lot(?)',[$_POST['gerer_idlot']]);
            $vue = new VueMessageGest('Le lot a bien été supprimé.<br><br>Cliquez sur les boutons ci-dessus pour naviguer sur le site');
            $vue->render();
        }catch (Exception $e){
            $vue = new VueMessageGest($e->getMessage());
            $vue->render();
        }
    }


    public static function insererComposition(){
        try{
            $prods = Produit::select('idproduit')->get()->all();
            if (isset($_POST['composition_idlot'])){
                $idLot = $_POST['composition_idlot'];
            }
            foreach ( $prods as $prod){
                if (isset($_POST['composition_' . $prod['idproduit']])){
                    if ($_POST['composition_' . $prod['idproduit']] > 0){
                        $comp = new AppartientA();
                        $comp->idproduit = (int)$prod['idproduit'];
                        $comp->quantite = $_POST['composition_' . $prod['idproduit']];
                        $comp->idlot = (int)$idLot;
                        $comp->save();
                    }
                }
            }
            $vue = new VueMessageGest('La composition du lot a bien étée créée.<br><br>Veuillez cliquez sur les boutons ci-dessus pour naviguer sur le site');
            $vue->render();
        }catch(Exception $e){
            $vue = new VueMessageGest($e->getMessage());
            $vue->render();
        }
    }

    public static function afficherLotsCli($id){
        $lots = Lot::where('etat','=','en vente')->get()->all();
        $res = "";
        foreach( $lots as $lot){
            $res .= <<<END
              <div class="form-group">
              <label class="col-md-4 control-label" for="idlot$lot[idlot]">ID : $lot[idlot] - $lot[description] - Fin : $lot[datefin]</label>
              <div class="col-md-4">    
                <a id="singlelink" href="/projet_csi/Projet_CSI/projetCSI/client/$id/propals?id=$id&lot=$lot[idlot]" class="btn btn-primary">Faire une proposition</a>
              </div>
            </div>    
            END;
        }
        $vue = new VueLotsCli($res,$id);
        $vue->render();
    }
}