<?php
namespace projet\vue;
use Slim\Slim;

class VuePrincipaleGest
{
    private $app;
    private $lienAccueil, $lienCli;
    private $URLbootstrapCSS;
    private $URLbootstrapJS;
    private $URLpersoCSS;
    private $URLimages;


    public function __construct() {
        $this->app = Slim::getInstance();
        $this->lienAfficherProduits = $this->app->urlFor('afficher_produits');
        $this->lienAccueil = $this->app->urlFor('page_index_gest');
        $this->lienCli = $this->app->urlFor('page_index_cli');
        $this->lienCreerProduits = $this->app->urlFor('creer_produits');
        $this->lienCreerLot = $this->app->urlFor('creer_lots');
        $this->lienGererLot = $this->app->urlFor('gerer_lot');
        $this->lienCreerComposition = $this->app->urlFor('creer_composition');
        $this->URLimages = $this->app->request->getRootUri() . '/img/';
        $this->URLbootstrapCSS = $this->app->request->getRootUri() . '/public/bootstrap.css';
        $this->URLbootstrapJS = $this->app->request->getRootUri() . '/public/boostrap.min.js';
        $this->URLpersoCSS = $this->app->request->getRootUri() . '/public/css_perso.css';
    }
    /*
    * permet l'obtention du menu de navigation
    */
    protected function getMenu()
    {
        return <<<END
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
                    <a class="navbar-brand" href="$this->lienAccueil">Projet CSI</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                          <span class="navbar-toggler-icon"></span>
                        </button>
                    <div class="collapse navbar-collapse" id="navbarResponsive">
                      <ul class="navbar-nav ml-auto">
                                            <li class="nav-item">
                          <a class="nav-link" href="$this->lienCli">Passer en mode Client</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="$this->lienAccueil">Accueil</a>
                        </li>

                        <li class="nav-item">
                          <a class="nav-link" href="$this->lienAfficherProduits">Afficher les produits</a>
                        </li>
                        
                        <li class="nav-item">
                          <a class="nav-link" href="$this->lienCreerProduits">Créer un produit</a>
                        </li>
                        
                        <li class="nav-item">
                          <a class="nav-link" href="$this->lienCreerLot">Créer un lot</a>
                        </li>
                        
                        <li class="nav-item">
                          <a class="nav-link" href="$this->lienGererLot">Gérer un lot</a>
                        </li>
                        
                        <li class="nav-item">
                          <a class="nav-link" href="$this->lienCreerComposition">Créer une composition</a>
                        </li>
                    <li class="nav-item">
                  </li>
                      </ul>
                    </div>
                  </div>
                </nav>
                </header>
END;
    }
    /*
    * fonction permet de recuperer facilement le footer
    */
    protected function getFooter()
    {
        return '<script src="$this->URLbootstrapJS"></script>
            </body>
        </html> ';
    }

    /**
     * retourne l'app de slim
     * @return Slim|null
     */
    public function getApp()
    {
        return $this->app;
    }
}