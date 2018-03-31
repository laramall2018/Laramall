<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table = 'goods_type';



    /*
    |-------------------------------------------------------------------------------
    |
    | 一对多的关系 一个商品类型下面可以有多个商品属性名称
    |
    |-------------------------------------------------------------------------------
    */
    public function attribute(){

    	return $this->hasMany(Attribute::class,'type_id','id');
    }
}
