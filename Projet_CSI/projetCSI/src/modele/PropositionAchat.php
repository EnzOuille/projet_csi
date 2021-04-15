<?php
namespace projet\modele;
class PropositionAchat extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'public.propositionachat';
    protected $primaryKey = 'idProposition';
    public $timestamps = false;


    public function propal_client() {
        return $this->belongsTo('projet\modele\Liste','idClient');
    }

    public function propal_lot() {
        return $this->belongsTo('projet\modele\Liste','idLot');
    }
}