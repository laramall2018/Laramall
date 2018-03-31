<?php

namespace LaraStore\Forms;

use App\Http\Controllers\Api\ApiController as Api;
use App\Models\User;
use Auth;

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
        'phone'     => 'required|digits:11',
        'password'  => 'required|min:6',
    ];


    /*
    |-------------------------------------------------------------------------------
    |
    | 注册表单验证规则提示信息
    |
    |-------------------------------------------------------------------------------
    */
    protected $messages = [
       	'phone.digits' =>'手机为11位数字',
        'password.min' =>'密码至少6位',
       
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
    	$info 			= 'success';
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
        $phone                      = $this->phone;
        $password                   = $this->password;
        $remember                   = ($this->remember == 1)? true:false;
        if(Auth::attempt("user",compact('phone','password'),true)){

               //登录成功 写入登录ip
               $user                = Auth::user('user');
               $user->loginIp();
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