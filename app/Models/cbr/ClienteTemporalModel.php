<?php
namespace App\Models\cbr;
use Illuminate\Database\Eloquent\Model;

class ClienteTemporalModel extends Model
{
    public $timestamps = false;
    protected $table = 'clientes_temporal';
}