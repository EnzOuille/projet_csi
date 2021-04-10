<?php
namespace projet\modele;
class AppartientA extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'public.appartienta';
    protected $primaryKey = ['idProduit','idClient'];
    public $timestamps = false;


    public function appartient_client() {
        return $this->belongsTo('projet\modele\Liste','idClient');
    }

    public function appartient_lot() {
        return $this->belongsTo('projet\modele\Liste','idLot');
    }
}