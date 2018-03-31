<?php

namespace LaraStore\Forms;

use App\Http\Controllers\Api\ApiController as Api;
use App\User;
use Auth;
use App\Models\Tag;
use App\Models\Goods;

class UserTagAddForm extends Form{

	public $api;
	/*
    |-------------------------------------------------------------------------------
    |
    | 注册表单验证规则
    |
    |-------------------------------------------------------------------------------
    */
    protected $rules = [

        'tag_name'=>'required|unique:tag,tag_name',
        'goods_id'=>'required|goods_exist',
        
    ];


    /*
    |-------------------------------------------------------------------------------
    |
    | 注册表单验证规则提示信息
    |
    |-------------------------------------------------------------------------------
    */
    protected $messages = [
       	'tag_name.required'     =>'标签名称必须填写',
        'goods_id.required'     =>'商品必须',
        'goods_id.goods_exist'  =>'商品必须存在',
    ];


    /*
    |-------------------------------------------------------------------------------
    |
    | 构造函数
    |
    |-------------------------------------------------------------------------------
    */
    public function __construct(Api $api){
       $this->api       = $api;
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
    	$tag 		= 'success';
    	$info 		= 'success';
        $user       = Auth::user('user');
        $tag_list   = $user->tag()->get();
        $goods_list = Goods::take(1000)->get();
    	return $this->api->respond(['data'=>compact('tag','info','tag_list','goods_list')]);
    	
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
            'tag_name'  =>$this->tag_name,
            'goods_id'  =>$this->goods_id,
            'sort_order'=>$this->sort_order,
            'username'  =>Auth::user('user')->username,
         ];
         Tag::create($data);
    }
}