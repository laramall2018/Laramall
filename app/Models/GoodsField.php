<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use LaraStore\Repository\GoodsField\BaseRepository;
class GoodsField extends Model
{   
    use BaseRepository;
    protected $table  = 'goods_field';
    /*
    |-------------------------------------------------------------------------------
    |
    | 一对多的关系 商品 - 商品规格值
    |
    |-------------------------------------------------------------------------------
    */
    public function goods(){

    	return $this->belongsTo(Goods::class,'goods_id','id');
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 一对多的关系 规格名称  规格值
    |
    |-------------------------------------------------------------------------------
    */
    public function field(){

    	return $this->belongsTo(Field::class,'field_id','id');
    }
}
