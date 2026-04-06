<?php
namespace App\Models\vta;
use Illuminate\Database\Eloquent\Model;

class ComprasModel extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_compras';
}

class ComprasProductoModel extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_compras_producto';
}