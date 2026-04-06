<?php
namespace App\Models\cbr;
use Illuminate\Database\Eloquent\Model;

class UsuarioModel extends Model
{
  protected $connection = 'cliente'; // 👈 CLAVE
  protected $table = "usuarios";
  protected $primaryKey = 'id';
  public $timestamps = false;
}
