<?php

namespace LaraStore\Forms\Supplier;

use App\Http\Controllers\Api\ApiController as Api;
use App\User;
use Auth;
use App\Models\Supplier;
use LaraStore\Forms\Form;

class RegisterForm extends Form{

	public $api;
	/*
    |-------------------------------------------------------------------------------
    |
    | 注册表单验证规则
    |
    |-------------------------------------------------------------------------------
    */
    protected $rules = [

        'username'		=>'required|unique:supplier,username',
        'email'			=>'required|unique:supplier,email|email',
        'phone'			=>'required|unique:supplier,phone|digits:11',
        'password'		=>'required|min:6',

        
    ];


    /*
    |-------------------------------------------------------------------------------
    |
    | 注册表单验证规则提示信息
    |
    |-------------------------------------------------------------------------------
    */
    protected $messages = [
        'phone.digits'		=>'手机号必须为11位数字',
        'username.unique'	=>'用户名已存在',
        'email.unique'		=>'电子邮件已存在',
        'phone.unique'		=>'手机号已经存在',
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
    |  json_decode 参数
    |
    |-------------------------------------------------------------------------------
    */
    public function attributes(){
    	return json_decode($this->param);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  获取参数数组
    |
    |-------------------------------------------------------------------------------
    */
    public function fields(){
    	return [

    			 'username'	=>$this->attributes()->username,
    			 'email'	=>$this->attributes()->email,
    			 'phone'	=>$this->attributes()->phone,
    			 'password'	=>$this->attributes()->password,
    	];
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
         $arr = [
            'reg_from'	=> 'pc版本',
            'ip'		=> request()->ip(),
            'add_time'	=> time(),
            'sort_order'=> 0,
            'tag'		=> 0,
            'password'	=> \Hash::make($this->attributes()->password),
         ];
         $data 	= array_merge($this->fields(),$arr);
         Supplier::create($data);
    }
}


