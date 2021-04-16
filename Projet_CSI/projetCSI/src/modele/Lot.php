<?php
namespace projet\modele;
class Lot extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'public.lot';
    protected $primaryKey = 'idlot';
    public $timestamps = false;

}