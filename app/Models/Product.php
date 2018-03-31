<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{	

	/*
    |-------------------------------------------------------------------------------
    |
    |  fillable用于模型存储时候和form递交过来的表单配合存储数据
    |
    |-------------------------------------------------------------------------------
    */
    protected $fillable = ['goods_id','product_sn','product_number','sort_order'];

    protected $table = 'product';


    /*
    |-------------------------------------------------------------------------------
    |
    | 一对多的关系 一个商品可以有多个货品值
    |
    |-------------------------------------------------------------------------------
    */
	public function goods(){

		// 第一个编号 为本模型对应的编号 第二个为关联的模型对应的编号
		return $this->belongsTo(Goods::class,'goods_id','id');
	}
}
