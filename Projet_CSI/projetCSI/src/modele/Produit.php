<?php
namespace projet\modele;
class Produit extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'public.produit';
    protected $primaryKey = 'idproduit';
    public $timestamps = false;

}