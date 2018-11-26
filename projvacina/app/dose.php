<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dose extends Model
{
    protected $fillable = ['nome','local','id_user','numerodose','validade'];
    protected $guarded = ['id','created_at','update_at'];
    protected $table = 'doses';
    
    // /**
    //  * Get da data de expiração da vacina.
    //  *
    //  * @param  string  $value
    //  * @return string
    //  */
    // public function getValidadeAttribute($value)
    // {
    //     return '123';
    // }
}
