<?php
namespace App\Models\cbr;
use Illuminate\Database\Eloquent\Model;

class GastosModel extends Model
{
    public $timestamps = false;
    protected $table = 'gasto';
}

class GastosGeneralesModel extends Model
{
    public $timestamps = false;
    protected $table = 'gastos_generales';
}

