<?php
namespace App\Models\cbr;
use Illuminate\Database\Eloquent\Model;

class LoginModel extends Model
{
    //public $timestamps = false;
    protected $connection = 'tenant';
    protected $table = 'usuarios';
    protected $fillable = [
        'nombre',
        'email',
        'password'
    ];
}