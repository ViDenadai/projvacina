<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vaccine extends Model
{
    protected $fillable = ['name'];
    protected $guarded = ['id'];
    protected $table = 'vaccines';
}
