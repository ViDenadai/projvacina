<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class role_user extends Model
{
    protected $fillable =['user_id','role_id'];
    protected $guarded=['id','created_at','update_at'];
    protected $table='role_user';
}
