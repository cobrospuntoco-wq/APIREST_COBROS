<?php
namespace App\Models\cbr;
use Illuminate\Database\Eloquent\Model;

class PaisModel extends Model
{
    public $timestamps = false;
    protected $table = 'pais';
}

class CiudadModel extends Model
{
    public $timestamps = false;
    protected $table = 'ciudad';
}

class BarriosModel extends Model
{
    public $timestamps = false;
    protected $table = 'localidad_barrio';
}

class InteresesModel extends Model
{
    public $timestamps = false;
    protected $table = 'lst_interes';
}

class TipogastoModel extends Model
{
    public $timestamps = false;
    protected $table = 'lst_tiposgasto';
}

class MaxCreditoModel extends Model
{
    public $timestamps = false;
    protected $table = 'max_credito';
}

class NumerosModel extends Model
{
    public $timestamps = false;
    protected $table = 'numeros';
}

class ConfigEmpresaModel extends Model
{
    public $timestamps = false;
    protected $table = 'tcp_cia';
}