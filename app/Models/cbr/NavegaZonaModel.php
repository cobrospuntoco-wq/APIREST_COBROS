<?php
namespace App\Models\cbr;
use Illuminate\Database\Eloquent\Model;

class NavegaZonaModel extends Model
{
    public $timestamps = false;
    protected $table = 'zona_nav';
}

class ZonaModel extends Model
{
    public $timestamps = false;
    protected $table = 'zonas';
}