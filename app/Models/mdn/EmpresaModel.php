<?php
namespace App\Models\mdn;
use Illuminate\Database\Eloquent\Model;

class EmpresaModel extends Model
{
    protected $connection = 'principal';
    protected $table = 'clientes_cobros';
    protected $primaryKey = 'id_int';
    public $timestamps = false;
    protected $fillable = [
        'idEmpresa',
        'nomEmpresa',
        'db_host',
        'db_name',
        'db_user',
        'db_pass'
    ];
}