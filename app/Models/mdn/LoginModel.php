<?php
namespace App\Models\mdn;
use Illuminate\Database\Eloquent\Model;

class LoginModel extends Model
{
  protected $connection = 'principal'; // 👈 CLAVE
  protected $table = "tbl_user_login";
  protected $primaryKey = 'ID_USER';
  public $timestamps = false;
}
