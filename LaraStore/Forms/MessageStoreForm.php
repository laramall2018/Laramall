<?php

namespace LaraStore\Forms;

use App\Http\Controllers\Api\ApiController as Api;
use App\User;
use Auth;
use App\Models\Message;

class MessageStoreForm extends Form{

	public $api;
	/*
    |-------------------------------------------------------------------------------
    |
    | 注册表单验证规则
    |
    |-------------------------------------------------------------------------------
    */
    protected $rules = [

        'content'=>'required',
        'type'   =>'required',
        'rank'   =>'required',
        'email'  =>'required|email',
        
    ];


    /*
    |-------------------------------------------------------------------------------
    |
    | 注册表单验证规则提示信息
    |
    |-------------------------------------------------------------------------------
    */
    protected $messages = [
       	'content.required'      =>'留言内容必须填写',
        'rank.required'         =>'评价登录必须填写',
        'type.required'         =>'类型必须填写',
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
    	$tag 		        = 'success';
    	$info 		        = 'success';
        $user               = Auth::user('user');
        $message_list       = $user->message()->get();
    	return $this->api->respond(['data'=>compact('tag','info','message_list')]);
    	
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
            'content'   =>$this->content,
            'type'      =>$this->type,
            'rank'      =>$this->rank,
            'username'  =>Auth::user('user')->username,
            'email'     =>$this->email,
            'add_time'  =>time(),
            'front_ip'  => request()->ip(),
         ];
         Message::create($data);
    }
}