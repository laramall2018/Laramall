<?php

namespace LaraStore\Forms\BatchOrder;
use Auth;
use App\Models\Goods;
use App\Models\Category;
use App\Http\Controllers\Api\ApiController as Api;
use LaraStore\BatchOrder\Common;
use LaraStore\Forms\Form;

class MakeToArrForm extends Form{

	public $api;
	/*
    |-------------------------------------------------------------------------------
    |
    | 表单验证规则
    |
    |-------------------------------------------------------------------------------
    */
    protected $rules = [

    	'orderStr'		=>'required'
        
    ];


    /*
    |-------------------------------------------------------------------------------
    |
    | 表单验证规则提示信息
    |
    |-------------------------------------------------------------------------------
    */
    protected $messages = [
       	
       	'orderStr.required'	=>'必须输入批量下单数据',
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
    |   isValid
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
    	$info 				= '批量下单格式正确，即将进入下一步';
        $common             = new Common($this->orderStr);
        $order_list         = $common->makeToArray()->make();

    	return $this->api->respond(['data'=>compact('tag','info','order_list')]);
    	
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   批量下单格式是否正确
    |
    |-------------------------------------------------------------------------------
    */
    public function orderCheck(){

        $common   = new Common($this->orderStr);

        //如果订单数据为空
        if($common->isEmpty()){
            return false;
        }

        //订单是否同时拥有商品和收货地址
        if(!$common->hasGoodsAndAddress()){
            return false;
        }

        //地址格式是否正确
        if(!$common->isAddress()){
            return false;
        }

        return true;
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
            $info               = $this->errors();
            return $this->api->respondCommonError($info);
        }

        $common                 = new Common($this->orderStr);
        //订单是否为空
        if($common->isEmpty()){
            $info               = '批量订单为空';
            return $this->api->respondCommonError($info);
        }

        //是否同时拥有商品和数据
        if(!$common->hasGoodsAndAddress()){

            return $this->api->respondCommonError($common->goodsAndAddressError());
        }

        //地址信息是否正确
        if(!$common->isAddress()){
            
            return $this->api->respondCommonError($common->addressError());
        }

    }

    
    /*
    |-------------------------------------------------------------------------------
    |
    | 处理数据库相关操作
    |
    |-------------------------------------------------------------------------------
    */
    public function persist()
    {
         return true;
    }
}