<?php
class Lots extends Controller {
    /**
     * Cette méthode affiche la liste des Lots
     *
     * @return void
     */
    public function index(){
        // On instancie le modèle "Lot"
        $this->loadModel('Lot');

        // On stocke la liste des Lot dans $lots
        $lots = $this->Lot->getAll();

        // On envoie les données à la vue index
        $this->render('index', compact('lots'));
    }

    /**
     * Méthode permettant d'afficher un lot à partir de son id
     *
     * @param string $id
     * @return void
     */
    public function lire(string $id){
        // On instancie le modèle "Lot"
        $this->loadModel('Lot');

        // On stocke l'article dans $article
        $lot = $this->Lot->findById($id);

        // On envoie les données à la vue lire
        $this->render('lire', compact('lot'));
    }
}