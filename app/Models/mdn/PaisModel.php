<?php
namespace App\Models\mdn;
use Illuminate\Database\Eloquent\Model;

class Paismodel extends Model
{
  protected $connection = 'principal';
  protected $table = "tbl_paises";
  //protected $primaryKey = "id";
  public $timestamps = false;
}