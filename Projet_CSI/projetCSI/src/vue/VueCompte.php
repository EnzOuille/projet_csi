<?php


namespace projet\vue;


class VueCompte
{

    private $app;
    private $liste, $typeAff, $urlAfficherToutesListes, $urlAfficherItemsListe, $urlITemID, $urlPageIndex, $urlCreerListe;
    private $URLbootstrapCSS, $URLbootstrapJS, $URLimages, $URLpersoCSS;

    public function __construct($typeAff) {
        $this->typeAff = $typeAff;
        $this->app =  \Slim\Slim::getInstance() ;

        $itemUrl1 =$this->app->urlFor('afficher_toutes_listes') ;
        $this->urlAfficherToutesListes = $itemUrl1 ;

        $itemUrl2 = $this->app->urlFor('afficher_items_dune_liste', ['no'=>1]) ;
        $this->urlAfficherItemsListe = $itemUrl2 ;

        $this->urlITemID = $this->app->urlFor('afficher_item_id', ['id'=>5]);

        $this->urlPageIndex = $this->app->urlFor('page_index');

        $itemUrl4 = $this->app->urlFor('creer_liste');
        $this->urlCreerListe = $itemUrl4;

        $this->URLimages = $this->app->request->getRootUri() . '/img/';
        $this->URLbootstrapCSS = $this->app->request->getRootUri() . '/public/bootstrap.css';
        $this->URLbootstrapJS = $this->app->request->getRootUri() . '/public/boostrap.min.js';
        $this->URLpersoCSS = $this->app->request->getRootUri() . '/public/css_perso.css';
    }


    /**
     * fonction utilisée pour le rendu des vues
     */
    public function render(){

        switch ($this->typeAff){
            case 'creerCompte' :{
                $content = $this->formulaireCreerCompte();
                break;
            }
            case 'confirm' : {
                $content = $this->pageConfirm();
            }
        }
        $html = <<<END
        <!DOCTYPE HTML>
        <html>
            <head>
                <link rel="stylesheet" href="$this->URLbootstrapCSS">
                <link rel="stylesheet" href="$this->URLpersoCSS">
                <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
            </head>
            <body>
                <header>
                <nav class="navbar navbar-expand-lg navbar-light bg-light shadow    ">
                  <div class="container">
                    <a class="navbar-brand" href="$this->urlPageIndex">My Wish List</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                          <span class="navbar-toggler-icon"></span>
                        </button>
                    <div class="collapse navbar-collapse" id="navbarResponsive">
                      <ul class="navbar-nav ml-auto">
                      <li class="nav-item">
                          <a class="nav-link" href="$this->urlPageIndex">Accueil</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="$this->urlAfficherToutesListes">Afficher la liste des listes
                              </a>
                        </li>
                       <li class="nav-item">
                      <a class="nav-link" href="$this->urlITemID">Affichage d'un item par id</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="$this->urlCreerListe">Creer une liste de souhait</a>
                  </li>
                      </ul>
                    </div>
                  </div>
                </nav>
                </header>
                <div class="container h-100">
                                
                       $content         
                                
                </div>
                <script src="$this->URLbootstrapJS"></script>
            </body>
        </html> 
        END ;
        echo $html;
    }

    private function formulaireCreerCompte()
    {
        $lienVersConfirm = $this->app->urlFor('compteConfirm');
        $html =  "<form class='form-horizontal' action=$lienVersConfirm method='POST'>
                              <fieldset>
                                <div id='legend'>
                                  <legend class=''>Register</legend>
                                </div>
                                <div class='control-group'>
                                  <!-- Username -->
                                  <label class='control-label'  for='username'>Username</label>
                                  <div class='controls'>
                                    <input type='text' id='username' name='username' placeholder='username' class='input-xlarge'>
                                    <p class='help-block'>Username can contain any letters or numbers, without spaces</p>
                                  </div>
                                </div>
                             
                                <div class='control-group'>
                                  <!-- E-mail -->
                                  <label class='control-label' for='email'>E-mail</label>
                                  <div class='controls'>
                                    <input type='text' id='email' name='email'  accept='' placeholder='email@mail.com' class='input-xlarge'>
                                    <p class='help-block'>Please provide your E-mail</p>
                                  </div>
                                </div>
                             
                                <div class='control-group'>
                                  <!-- Password-->
                                  <label class='control-label' for='password'>Password</label>
                                  <div class='controls'>
                                    <input type='password' id='password' name='password' placeholder='motdepasse' class='input-xlarge'>
                                    <p class='help-block'>Password should be at least 4 characters</p>
                                  </div>
                                </div>
                             
                                <div class='control-group'>
                                  <!-- Password -->
                                  <label class='control-label' for='password_confirm'>Password (Confirm)</label>
                                  <div class='controls'>
                                    <input type='password' id='password_confirm' name='password_confirm' placeholder='' class='input-xlarge'>
                                    <p class='help-block'>Please confirm password</p>
                                  </div>
                                </div>
                             
                                <div class='control-group'>
                                  <!-- Button -->
                                  <div class='controls'>
                                    <button class='btn btn-success'>Register</button>
                                  </div>
                                </div>
                              </fieldset>
                    </form>";
        return $html;
    }

    private function pageConfirm()
    {
        $html = $_POST['username'] . "    " . $_POST['password'] . "    " . $_POST['email'];
        return $html;
    }

}