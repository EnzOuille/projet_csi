<?php

session_start();
require 'vendor/autoload.php' ;
use projet\controller\ProduitController;
use projet\controller\PropositionController;
use projet\controller\IndexController;
use projet\controller\LotController;
use Illuminate\Database\Capsule\Manager as DB;
require 'vendor/autoload.php';


$file = parse_ini_file('src/conf/conf.ini');
$db = new DB();
$db->addConnection($file);
$db->setAsGlobal();
$db->bootEloquent();

$app = new \Slim\Slim();

$app->get('/gestionnaire', function () {
    IndexController::interfaceAccueilGest();
})->name('page_index_gest');

$app->get('/client', function () {
    IndexController::interfaceAccueilCli();
})->name('page_index_cli');

$app->get('/gestionnaire/produit/afficher',function(){
    ProduitController::afficherToutProduits();
})->name('afficher_produits');

$app->get('/client/:id/propals',function($id){
    PropositionController::afficherPropals($id);
})->name('afficher_propals_client');

$app->get('/gestionnaire/produit/creer',function(){
    ProduitController::afficher_creer_produit();
})->name('creer_produits');

$app->post('/gestionnaire/produit/creer',function(){
    echo 'Coucou';
    ProduitController::creer_produit();
})->name('creer_produits_post');

$app->get('/gestionnaire/lot/creer',function(){
    LotController::afficher_creer_Lot();
})->name('creer_lots');

$app->post('/gestionnaire/lot/creer',function(){
    LotController::creerLot();
})->name('creer_lots_post');

$app->get('/gestionnaire/lot/composition',function(){
    LotController::creerComposition();
})->name('creer_composition');

$app->post('/gestionnaire/lot/composition',function(){
    LotController::insererComposition();
})->name('creer_composition_post');

$app->run();