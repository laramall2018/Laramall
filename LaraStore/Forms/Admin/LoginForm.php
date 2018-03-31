<?php

namespace LaraStore\Forms\Admin;

use App\Http\Controllers\Api\ApiController as Api;
use App\Models\Admin;
use Auth;
use LaraStore\Forms\Form;

class LoginForm extends Form{

	protected $api;
	/*
    |-------------------------------------------------------------------------------
    |
    | 注册表单验证规则
    |
    |-------------------------------------------------------------------------------
    */
    protected $rules = [
        'username'      => 'required',
        'password'  	=> 'required|min:6',
    ];


    /*
    |-------------------------------------------------------------------------------
    |
    | 注册表单验证规则提示信息
    |
    |-------------------------------------------------------------------------------
    */
    protected $messages = [
       	'username.required' 	=>'管理员名称必须填写',
        'password.required' 	=>'密码必须填写',
        'password.min'			=>'密码至少6位数以上',
       
    ];



    /*
    |-------------------------------------------------------------------------------
    |
    | 表单格式验证错误
    |
    |-------------------------------------------------------------------------------
    */
    public function errorRespond(){

    	if(!$this->isValid()){
            $info               = $this->errors();
    		return $this->api->respondCommonError($info);
    	}
        //账号密码错误
        if(!$this->login()){
            $info               = '账号密码错误';
            return $this->api->respondCommonError($info);
        }
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  保存成功 返回api信息
    |
    |-------------------------------------------------------------------------------
    */
    public function successRespond(){
        $this->login();
    	$tag 			= 'success';
    	$info 			= '登录成功';
    	return $this->api->respond(['data'=>compact('tag','info')]);
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |  用户登录
    |
    |-------------------------------------------------------------------------------
    */
    public function login(){
    	
    	//验证通过后 登录
        $username                   = $this->username;
        $password                   = $this->password;
        if(Auth::attempt("admin",compact('username','password'),true)){

               return true;
         }
         return false;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  用户登录
    |
    |-------------------------------------------------------------------------------
    */
    public function persist(){
    	return true;
    }


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
}