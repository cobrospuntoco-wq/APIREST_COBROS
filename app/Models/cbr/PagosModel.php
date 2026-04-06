<?php
namespace App\Models\cbr;
use Illuminate\Database\Eloquent\Model;

class PagosModel extends Model
{
    protected $table = 'pago';
    protected $primaryKey = 'id';
    public $timestamps = false;
}