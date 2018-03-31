<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Phpstore\Repository\CartRepository;

class Cart extends Model{

    use CartRepository;	
	protected $table 		= 'cart';

	protected $fillable 	= [ 
								'goods_id',
								'goods_sn',
								'product_id',
								'goods_name',
								'market_price',
								'shop_price',
								'goods_number',
								'goods_attr',
								'user_id',
								'session_id',
								'thumb',
                                'is_checked',
							  ];

	

    

    /*
    |-------------------------------------------------------------------------------
    |
    | 商品模型和购物车模型为 一对多的关系
    |
    |-------------------------------------------------------------------------------
    */
    public function goods(){


    	return $this->belongsTo(Goods::class,'goods_id','id');
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 购物车和用户的关系 一对多 一个购物车属于某个用户
    |
    |-------------------------------------------------------------------------------
    */
    public function user(){

        return $this->belongsTo('App\User','user_id','id');
    }

    
}