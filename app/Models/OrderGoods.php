<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Phpstore\Repository\OrderGoodsRepository;
class OrderGoods extends Model{

	use OrderGoodsRepository;
	protected $table 		= 'order_goods';

	protected $fillable 	= [
									'order_id',			//订单编号
									'goods_id', 		//商品编号
									'goods_name',		//商品名称
									'goods_sn',			//商品货号
									'goods_number',		//商品库存
									'market_price',		//市场价格
									'shop_price',		//店铺价格
									'goods_attr',		//属性

	];


	/*
    |-------------------------------------------------------------------------------
    |
    |   订单和订单中产品 为一对多的关系
    |
    |-------------------------------------------------------------------------------
    */
    public function order(){

    	return $this->belongsTo(Order::class,'order_id','id');
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |   订单中商品 和商品模型关系  一对多
    |
    |-------------------------------------------------------------------------------
    */
    public function goods(){

    	return $this->belongsTo(Goods::class,'goods_id','id');
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |   返回每条记录产品的金额
    |
    |-------------------------------------------------------------------------------
    */
    public function total(){

         return ($this->shop_price) * ($this->goods_number);
    }

}