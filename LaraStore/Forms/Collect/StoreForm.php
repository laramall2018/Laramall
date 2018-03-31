<?php

namespace LaraStore\Forms\Collect;

use App\Http\Controllers\Api\ApiController as Api;
use App\User;
use Auth;
use App\Models\CollectGoods;
use LaraStore\Forms\Form;

class StoreForm extends Form{

	public $api;
	public $repository;
	/*
    |-------------------------------------------------------------------------------
    |
    | 注册表单验证规则
    |
    |-------------------------------------------------------------------------------
    */
    protected $rules = [

        'goods_id'=>'required|goods_exist|collect_exist',
        
    ];


    /*
    |-------------------------------------------------------------------------------
    |
    | 注册表单验证规则提示信息
    |
    |-------------------------------------------------------------------------------
    */
    protected $messages = [
        'goods_id.required'     	=>'商品必须',
        'goods_id.goods_exist'  	=>'商品必须存在',
        'goods_id.collect_exist'	=>'商品已收藏',
    ];


    /*
    |-------------------------------------------------------------------------------
    |
    | 构造函数
    |
    |-------------------------------------------------------------------------------
    */
    public function __construct(Api $api){
       $this->api       		= $api;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  验证用户是否登录
    |
    |-------------------------------------------------------------------------------
    */
    public function auth(){

    	return (Auth::check('user'))? true:false;
    }





    /*
    |-------------------------------------------------------------------------------
    |
    |  成功后返回
    |
    |-------------------------------------------------------------------------------
    */
    public function successRespond(){

        $this->save();
    	$tag 			= 'success';
    	$info 			= 'success';
        $user       	= Auth::user('user');
        $collect_list 	= $user->collect()->get();
    	return $this->api->respond(['data'=>compact('tag','info','collect_list')]);
    	
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  验证未通过返回错误信息
    |
    |-------------------------------------------------------------------------------
    */
    public function errorRespond(){

    	if(!$this->auth()){
            $info               = '用户未登录';
    		return $this->api->respondCommonError($info);
    	}

        if(!$this->isValid()){
            $info               = $this->errors();
            return $this->api->respondCommonError($info);
        }
    	
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 存储注册表单中的数据到数据库
    |
    |-------------------------------------------------------------------------------
    */
    public function persist()
    {
         $data = [
            'goods_id'	=> $this->goods_id,
            'user_id'	=> Auth::user('user')->id,
            'add_time'	=> time(),
         ];
         CollectGoods::create($data);
    }
}
