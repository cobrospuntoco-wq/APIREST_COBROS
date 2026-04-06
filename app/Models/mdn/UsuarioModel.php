<?php
namespace App\Models\mdn;
use Illuminate\Database\Eloquent\Model;

class UsuarioModel extends Model
{
  protected $connection = 'principal'; // 👈 CLAVE
  protected $table = "tbl_user_login";
  protected $primaryKey = 'ID_USER';
  public $timestamps = false;
}

class UserRoll extends Model
{
  public $timestamps = false;
  protected $table = "tbl_user_roll";
  protected $primaryKey = "ID";
}


class UserPermiso extends Model
{
  public $timestamps = false;
  protected $table = "tbl_user_permiso";
  protected $primaryKey = "ID";
}

class UserAcceso extends Model
{
  public $timestamps = false;
  protected $table = "tbl_user_acceso";
  protected $primaryKey = "ID";
}

class GT_user extends Model
{
  public $timestamps = false;
  protected $table = "tbl_gt_user";
  protected $primaryKey = "ID";
}
