<?php
namespace App\Models\vta;
use Illuminate\Database\Eloquent\Model;

class ProductoModel extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_producto';
}

class ProductoVentaModel extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_producto_vender';
}