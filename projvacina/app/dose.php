<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class dose extends Model
{
    protected $fillable =['nome','local','id_user','numerodose','validade'];
    protected $guarded=['id','created_at','update_at'];
    protected $table='doses';
    
}
