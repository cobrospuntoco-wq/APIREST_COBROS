<?php
namespace App\Models\cbr;
use Illuminate\Database\Eloquent\Model;

class AgendaCobroModel extends Model
{
    public $timestamps = false;
    protected $table = 'proxima_visita';
}

class AgendaCobroAuxModel extends Model
{
    public $timestamps = false;
    protected $table = 'proxima_visita_aux';
}

class UbicacionCobroModel extends Model
{
    public $timestamps = false;
    protected $table = 'ubica_visita';
}