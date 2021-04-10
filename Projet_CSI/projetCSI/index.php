<?php

session_start();
require 'vendor/autoload.php' ;
use projet\controller\ProduitController;
use projet\controller\IndexController;
use Illuminate\Database\Capsule\Manager as DB;
require 'vendor/autoload.php';


$file = parse_ini_file('src/conf/conf.ini');
$db = new DB();
$db->addConnection($file);
$db->setAsGlobal();
$db->bootEloquent();

$app = new \Slim\Slim();

$app->get('/', function () {
    IndexController::interfaceAccueil();
})->name('page_index');

$app->get('/produit/afficher',function(){
    ProduitController::afficherToutProduits();
})->name('afficher_produits');

$app->run();