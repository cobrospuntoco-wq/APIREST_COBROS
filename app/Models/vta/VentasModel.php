<?php
namespace App\Models\vta;
use Illuminate\Database\Eloquent\Model;

class VentasModel extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_ventas';
}
class VentasProductoModel extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_ventas_producto';
}