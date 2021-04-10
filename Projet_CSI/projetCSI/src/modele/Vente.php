<?php
namespace projet\modele;
class Vente extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'public.vente';
    protected $primaryKey = 'idVente';
    public $timestamps = false;

    public function vente_client() {
        return $this->belongsTo('projet\modele\Liste','idClient');
    }

    public function vente_lot() {
        return $this->belongsTo('projet\modele\Liste','idLot');
    }
}