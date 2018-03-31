<?php

namespace LaraStore\Forms\Comment;

use App\Http\Controllers\Api\ApiController as Api;
use App\User;
use Auth;
use App\Models\Goods;
use App\Models\Message;
use LaraStore\Forms\Form;

class StoreForm extends Form{

	public $api;
	/*
    |-------------------------------------------------------------------------------
    |
    | 注册表单验证规则
    |
    |-------------------------------------------------------------------------------
    */
    protected $rules = [

        'rank'      =>'required',
        'content'   =>'required',
    ];


    /*
    |-------------------------------------------------------------------------------
    |
    | 注册表单验证规则提示信息
    |
    |-------------------------------------------------------------------------------
    */
    protected $messages = [
        'rank.required'     	    =>'等级必须',
        'content.required'  	    =>'评价内容必须填写',
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
    |  验证模型是否为空
    |
    |-------------------------------------------------------------------------------
    */
    public function isNotEmpty(){

        return empty(Goods::find($this->id))? false : true;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  是否错误
    |
    |-------------------------------------------------------------------------------
    */
    public function isAllCheck(){

        return  ($this->auth() && $this->isValid() && $this->isNotEmpty()) ? true :false;
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
        $goods          = Goods::find($this->id);
        $comment_list   = $goods->presenter()->comment();
    	return $this->api->respond(['data'=>compact('tag','info','comment_list')]);
    	
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

        if(!$this->isNotEmpty()){
            $info               = '商品模型为空';
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
            'type'          =>'评价',
            'content'       => $this->content,
            'add_time'      => time(),
            'rank'          => $this->rank,
            'front_ip'      =>request()->ip(),
            'id_value'      => $this->id,
            'add_time'	    =>time(),
            'username'      => Auth::user('user')->username,
            'email'         => Auth::user('user')->email,
            'status'        => 1,
         ];
         Message::create($data);
    }
}
