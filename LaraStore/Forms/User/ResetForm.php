<?php

namespace LaraStore\Forms\User;

use Auth;
use Hash;
use App\User;
use LaraStore\Forms\Form;
use LaraStore\Sms\Sms;
use App\Http\Controllers\Api\ApiController as Api;

class ResetForm extends Form{

	public $api;
    
	/*
    |-------------------------------------------------------------------------------
    |
    | 表单验证规则
    |
    |-------------------------------------------------------------------------------
    */
    protected $rules = [
    	'phone'		=> 'required|digits:11',
    	'password'  => 'required|min:6',
        'code'      => 'required|sms',
        
    ];


    /*
    |-------------------------------------------------------------------------------
    |
    | 表单验证规则提示信息
    |
    |-------------------------------------------------------------------------------
    */
    protected $messages = [

    	'phone.required' 	=>'手机号必须',
    	'phone.digits'	 	=>'手机号为11位',
    	'password.required'	=>'密码必须',
    	'code.required'		=>'验证码必须',
    	'code.sms'			=>'验证码错误',
       	
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
    |  品牌模型是否为空
    |
    |-------------------------------------------------------------------------------
    */
    public function hasPhone(){

        return ($user = User::where('phone',$this->phone)->first())? true :false;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  通过手机号码 返回该用户
    |
    |-------------------------------------------------------------------------------
    */
    public function user(){

    	return  User::where('phone',$this->phone)->first();
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  所有验证
    |
    |-------------------------------------------------------------------------------
    */
    public function allValid(){

    	return ($this->isValid() && $this->hasPhone()) ? true :false;
    }




    /*
    |-------------------------------------------------------------------------------
    |
    |  成功后返回
    |
    |-------------------------------------------------------------------------------
    */
    public function successRespond(){

       $this->resetPassword();
       $tag 			= 'success';
       $info 			= '成功充值密码';

       return $this->api->respond(['data'=>compact('tag','info')]);
    	
    }
    

    /*
    |-------------------------------------------------------------------------------
    |
    |  验证未通过返回错误信息
    |
    |-------------------------------------------------------------------------------
    */
    public function errorRespond(){

        //表单验证不通过
        if(!$this->isValid()){

            $info               = $this->errors();
            return $this->api->respondCommonError($info);
        }

        //用户不存在
        if(!$this->hasPhone()){

            $info               = '账号不存在';
            return $this->api->respondCommonError($info);
        }
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 充值用户密码
    |
    |-------------------------------------------------------------------------------
    */
    public function resetPassword(){

    	if(!$this->allValid()){

    		return false;
    	}

    	$user 				= $this->user();
    	$user->password 	= Hash::make($this->password);
    	$user->save();
    	//销毁会话中的验证码
        (new Sms())->put('phone',$this->phone)->destroy();
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