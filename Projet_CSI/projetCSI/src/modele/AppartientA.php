<?php
namespace projet\modele;
class AppartientA extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'public.appartienta';
    protected $primaryKey = 'idproduit';
    public $timestamps = false;


    public function appartient_client() {
        return $this->belongsTo('projet\modele\Client','idclient');
    }

    public function appartient_lot() {
        return $this->belongsTo('projet\modele\Lot','idlot');
    }
}