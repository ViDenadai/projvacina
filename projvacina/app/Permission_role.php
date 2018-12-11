<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission_role extends Model
{
    protected $fillable =['permission_id','role_id'];
    protected $guarded=['id'];
    protected $table='permission_role';
    
}