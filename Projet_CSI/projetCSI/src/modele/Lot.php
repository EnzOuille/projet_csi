<?php
namespace projet\modele;
class Lot extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'public.lot';
    protected $primaryKey = 'idLot';
    public $timestamps = false;

}