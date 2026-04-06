<?php
namespace App\Models\cbr;
use Illuminate\Database\Eloquent\Model;

class JornadaModel extends Model
{
    public $timestamps = false;
    protected $table = 'jornada';
}

class JornadaGeneralModel extends Model
{
    public $timestamps = false;
    protected $table = 'jornada_gral';
}