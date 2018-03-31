<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Phpstore\Repository\GoodsAttrRepository;

class GoodsAttr extends Model{

	use GoodsAttrRepository;
	protected $table 		= 'goods_attr';
	//白名单
	protected $fillable 	= ['attr_id','attr_value','attr_price'];
	protected $appends 		= ['attrName'];



	/*
    |-------------------------------------------------------------------------------
    |
    | 一对多的关系 一个商品可以有多个商品属性
    |
    |-------------------------------------------------------------------------------
    */
	public function goods(){

		// 第一个编号 为本模型对应的编号 第二个为关联的模型对应的编号
		return $this->belongsTo(Goods::class,'goods_id','id');
	}


	/*
    |-------------------------------------------------------------------------------
    |
    | 一对多的关系 一个属性名称可以有多个商品属性
    |
    |-------------------------------------------------------------------------------
    */
	public function attribute(){

		// 第一个编号 为本模型对应的编号 第二个为关联的模型对应的编号
		return $this->belongsTo(Attribute::class,'attr_id','id');
	}

}