<?php

namespace LaraStore\Forms\BatchOrder;
use Auth;
use App\Models\Goods;
use App\Models\Category;
use App\Http\Controllers\Api\ApiController as Api;
use LaraStore\BatchOrder\Common;
use LaraStore\Forms\Form;
use LaraStore\BatchOrder\OrderAction;

class OrderForm extends Form{

	public $api;
	/*
    |-------------------------------------------------------------------------------
    |
    | 表单验证规则
    |
    |-------------------------------------------------------------------------------
    */
    protected $rules = [

    	
        
    ];


    /*
    |-------------------------------------------------------------------------------
    |
    | 表单验证规则提示信息
    |
    |-------------------------------------------------------------------------------
    */
    protected $messages = [
       	
       
    ];


    /*
    |-------------------------------------------------------------------------------
    |
    | 构造函数
    |
    |-------------------------------------------------------------------------------
    */
    public function __construct(Api $api){
       $this->api           = $api;
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |   获取参数
    |
    |-------------------------------------------------------------------------------
    */
    public function attributes(){

    	return  json_decode($this->param);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   isValid
    |
    |-------------------------------------------------------------------------------
    */
    public function isValid(){

    	$attributes 		=  $this->attributes();
    	$keys 				= $attributes->keys;
    	foreach($keys as $item){

    		 $goods_ids_key 	= 'goods_ids'.$item;
    		 $goods_ids 		= $attributes->$goods_ids_key;
    		 $length 			= count($goods_ids);

    		 if($length == 0){

    		 	return false;
    		 }
    	}

    	return true;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   是否登录验证
    |
    |-------------------------------------------------------------------------------
    */
    public function auth(){

        return (Auth::check('user'))? true :false;
    }

    

    /*
    |-------------------------------------------------------------------------------
    |
    |  成功后返回
    |
    |-------------------------------------------------------------------------------
    */
    public function successRespond(){

    	$tag 				= 'success';
    	$info 				= '成功下单';
    	$orders 			= $this->order()->handle();
    	return $this->api->respond(['data'=>compact('tag','info','orders')]);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  验证未通过返回错误信息
    |
    |-------------------------------------------------------------------------------
    */
    public function errorRespond(){

        //登录后才可以批量下单
    	if(!$this->auth()){
            $info               = '请登录后再下单';
    		return $this->api->respondCommonError($info);
    	}
        //是否输入批量数据
        if(!$this->isValid()){
            $info               = '订单数据异常';
            return $this->api->respondCommonError($info);
        }

    }



    /*
    |-------------------------------------------------------------------------------
    |
    |  处理订单的类
    |
    |-------------------------------------------------------------------------------
    */
    public function order(){

    	return new OrderAction($this->attributes());
    }

    
    /*
    |-------------------------------------------------------------------------------
    |
    | 根据相关数据 生成订单信息
    |
    |-------------------------------------------------------------------------------
    */
    public function persist()
    {
         $this->order()->handle();
    }
}