<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model{

	
	protected $table = 'attribute';



	/*
    |-------------------------------------------------------------------------------
    |
    | 一对多的关系 一个属性名称可以有多个商品属性值
    |
    |-------------------------------------------------------------------------------
    */
    public function attr(){

        return $this->hasMany(GoodsAttr::class,'attr_id','id');
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 一对多的关系 一个属性属于某个具体的商品类型
    |
    |-------------------------------------------------------------------------------
    */
    public function type(){

        return $this->belongsTo(Type::class,'type_id','id');
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 多对多的关联
    |
    |-------------------------------------------------------------------------------
    */
    public function goods(){

        return $this->belongsToMany(Goods::class,'goods_attr','attr_id','goods_id');
    }

}