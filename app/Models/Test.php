<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    //访问控制器
    protected $appends = ['amount'];
    /*
    |-------------------------------------------------------------------------------
    |
    |   Test::where('tag',1)
    |
    |-------------------------------------------------------------------------------
    */
    public function scopeTag($query){

    	return $this->where('tag',1);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   访问器
    |
    |-------------------------------------------------------------------------------
    */
    public function getAmountAttribute(){

    	return '￥'.$this->price;
    }
}
