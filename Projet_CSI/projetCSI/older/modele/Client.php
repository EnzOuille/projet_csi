<?php
namespace projet\modele;
class Client extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'public.Client';
    protected $primaryKey = 'idClient';
    public $timestamps = false;

}