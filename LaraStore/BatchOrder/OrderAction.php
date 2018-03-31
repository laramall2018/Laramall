<?php

namespace LaraStore\BatchOrder;
use App\Models\Order;
use App\Models\OrderGoods;
use App\Models\Shipping;
use App\Models\Payment;
use App\Models\Goods;
use Auth;

class OrderAction{

	protected $goods_ids;
	protected $attrs;
	protected $goods_numbers;
	protected $username;
	protected $phone;
	protected $address;
	protected $order;
	protected $orders  = [];

	/*
    |-------------------------------------------------------------------------------
    |
    |  构造函数
    |
    |-------------------------------------------------------------------------------
    */
    public function __construct($attributes){

    	$this->attributes 		=  $attributes;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  处理订单
    |
    |-------------------------------------------------------------------------------
    */
    public function handle(){

    	$keys 					= $this->attributes->keys;
    	//循环的生成每个订单
    	foreach($keys as $key){

    		$this->key 			= $key;
    		$this->boot()->create();
    	}

    	//返回生成的订单模型数组
    	return $this->orders;
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  参数初始化
    |
    |-------------------------------------------------------------------------------
    */
    public function boot(){

    	 //获取商品信息
    	 $goods_ids_key 			= 'goods_ids'.$this->key;
    	 $this->goods_ids 			= $this->attributes->$goods_ids_key;

    	 //商品属性信息
    	 $attrs_key 				= 'attrs'.$this->key;
    	 $this->attrs 				= $this->attributes->$attrs_key;

    	 //商品数量
    	 $goods_numbers_key 		= 'goods_numbers'.$this->key;
    	 $this->goods_numbers 		= $this->attributes->$goods_numbers_key;

    	 //用户姓名
    	 $usernames_key 			= 'usernames'.$this->key;
    	 $usernames 				= $this->attributes->$usernames_key;
    	 $this->username 			= $usernames[0];

    	 //手机号码
    	 $phones_key 				= 'phones'.$this->key;
    	 $phones 					= $this->attributes->$phones_key;
    	 $this->phone 				= $phones[0];

    	 //地址信息
    	 $address_key 				= 'address'.$this->key;
    	 $address 					= $this->attributes->$address_key;
    	 $this->address 			= $address[0];

    	 return $this;
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  生成单个订单
    |
    |-------------------------------------------------------------------------------
    */
    public function create(){

    	$data   = [
           'order_sn'       	=> Order::order_sn(),             //订单编号
           'user_id'        	=> Auth::user('user')->id,        //下单用户
           'order_status'   	=> 0,                             //订单状态
           'shipping_status'   	=> 0,                             //物流状态
           'pay_status'        	=> 0,                             //支付状态
           'consignee'          => $this->username,               //收货人姓名
           'country'            => 1,                             //国家
           'address'            => $this->address,                //地址
           'phone'              => $this->phone,                  //手机
           'email'              => Auth::user('user')->email,     //电子邮件
           'shipping_id'        => Shipping::def()->id,           //配送方式编号
           'shipping_name'      => Shipping::def()->shipping_name,
           'pay_id'             => Payment::def()->id,            //支付编号
           'pay_name'           => Payment::def()->pay_name,      //支付名称
           'goods_amount'       => $this->getGoodsAmount(),       //商品总金额
           'shipping_fee'       => Shipping::def()->fee, 	      //运费
           'order_amount'       => $this->getOrderAmount(),       //订单总金额
           'add_time'           => time(),                        //订单生成时间
           'ip'                 => request()->getClientIP(),      //下单ip地址
           'order_note'         =>'',                             //订单注释
           'order_from'         =>'批量下单',                       //订单来源
        ];

        //创建订单数据
        if($order = Order::create($data)){

        	 $this->order  		= $order;
        	 $this->createOrderGoods();
        	 $this->orders[]    = $order;
        }
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  生成订单商品数据
    |
    |-------------------------------------------------------------------------------
    */
    public function createOrderGoods(){

    	foreach($this->goods_ids as $key=>$value){

    		$model 	= Goods::find($value);
    		$data   = [
                'order_id'     =>$this->order->id,               //订单编号
                'goods_id'     =>$value,                		//商品编号
                'goods_name'   =>$model->goods_name,       		//商品名称
                'goods_sn'     =>$model->goods_sn,         		//商品货号
                'goods_number' =>$this->goods_numbers[$key],    //商品库存
                'market_price' =>$model->market_price,     	    //市场价格
                'shop_price'   =>$model->shop_price,       		//店铺价格
                'goods_attr'   =>$this->attrs[$key],       		//属性
            ];
            OrderGoods::create($data);
    	}
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |  获取订单总的商品金额
    |
    |-------------------------------------------------------------------------------
    */
    public function getGoodsAmount(){

    	$amount 			= 0;
    	foreach($this->goods_ids as $key=>$value){

    		 $goods 		= Goods::find($value);
    		 $goods_numbers = $this->goods_numbers;
    		 $goods_number 	= $goods_numbers[$key];

    		 $amount 		= $amount + ($goods->shop_price)*$goods_number; 
    	}

    	return $amount;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  获取运费
    |
    |-------------------------------------------------------------------------------
    */
    public function getShippingFee(){

    	return  Shipping::def()->fee;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  获取订单总金额
    |
    |-------------------------------------------------------------------------------
    */
    public function getOrderAmount(){

    	$goods_amount 	= $this->getGoodsAmount();
    	$fee 			= $this->getShippingFee();
    	return $goods_amount + $fee;
    }



}