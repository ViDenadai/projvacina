<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role_user extends Model
{
    protected $fillable =['user_id','role_id'];
    protected $guarded=['id'];
    protected $table='role_user';
    
}
