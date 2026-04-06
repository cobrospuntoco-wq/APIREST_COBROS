<?php
namespace App\Models\mdn;
use Illuminate\Database\Eloquent\Model;

class UsuarioClaimModel extends Model
{
    protected $connection = 'principal';
    protected $table = 'claims_cobros';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'id',   
        'id_empresa',
        'id_pais',
        'código_2dofactor',
        'expiracion_factor',
        'email',
        'usuario',
        'estado'
    ];
}