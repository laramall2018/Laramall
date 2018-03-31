<?php

namespace LaraStore\Sms;


class Sms{


	protected $phone;
	protected $key;
	/*
    |-------------------------------------------------------------------------------
    |
    | 构造函数
    |
    |-------------------------------------------------------------------------------
    */
    public function __construct(){
    	
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 设置属性 链似操作
    |
    |-------------------------------------------------------------------------------
    */
    public function put($key,$value){

    	$this->$key 		= $value;
    	return $this;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取key
    |
    |-------------------------------------------------------------------------------
    */
    public function sessionKey(){

    	return $this->phone.'_auth_code_'.date('Y-m-d');
    }


	/*
    |-------------------------------------------------------------------------------
    |
    | 发送短信函数
    |
    |-------------------------------------------------------------------------------
    */
    public function send(){

        require app_path().'/taobao/TopSdk.php';
        $number     = rand(1000,9999);

        $c = new \TopClient;
        $c->appkey = env('ALISMS_KEY');
        $c->secretKey = env('ALISMS_SECRETKEY');
        $req = new \AlibabaAliqinFcSmsNumSendRequest;
        $req->setExtend("123456");
        $req->setSmsType("normal");
        $req->setSmsFreeSignName("阿里云短信测试专用");
        $req->setSmsParam("{\"number\":\"$number\",\"product\":\"阿里云短信测试专用\"}");
        //$req->setSmsParam($str);
        $req->setRecNum($this->phone);
        $req->setSmsTemplateCode("SMS_12977527");
        $resp = $c->execute($req);
        //把验证码加入到会话中
        session()->put($this->sessionKey(),$number);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 注册成功后  销毁会话中的验证码
    |
    |-------------------------------------------------------------------------------
    */
    public function destroy(){

    	session()->forget($this->sessionKey());
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取验证码
    |
    |-------------------------------------------------------------------------------
    */
    public function get(){
    	if(session()->has($this->sessionKey())){
    		return session()->get($this->sessionKey());
    	}
    	return false;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 验证短信验证码
    |
    |-------------------------------------------------------------------------------
    */
    public function validate(){

    	if(!$this->get()){
    		return false;
    	}
    	return ($this->get() == request()->code)? true:false;
    }
}