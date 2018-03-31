<?php

namespace LaraStore\Forms;
use App\Http\Controllers\Api\ApiController as Api;
use LaraStore\Sms\Sms;
use App\User;
use Auth;

class UserUpdateForm extends Form{

	protected $api;
    protected $user;
	/*
    |-------------------------------------------------------------------------------
    |
    | 注册表单验证规则
    |
    |-------------------------------------------------------------------------------
    */
    protected $rules = [
        'phone'     => 'required|digits:11',
        'email'     => 'required|email',
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
        'email.email'  =>'电子邮件格式错误',
    ];


    /*
    |-------------------------------------------------------------------------------
    |
    | 构造函数
    |
    |-------------------------------------------------------------------------------
    */
    public function __construct(Api $api,User $user){
       $this->api       = $api;
       $this->user      = $user;
    }




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
    }



    
    /*
    |-------------------------------------------------------------------------------
    |
    |  保存成功 返回api信息
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
    | 存储注册表单中的数据到数据库
    |
    |-------------------------------------------------------------------------------
    */
    public function persist()
    {   

        $attribute          = $this->attribute();
        $data               = $this->fields();
        if($attribute->password){
            $data['password'] = \Hash::make($attribute->password);
        }
        $this->user->update($data);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 把数据进行一次json_decode转化
    |
    |-------------------------------------------------------------------------------
    */
    public function attribute(){

        return json_decode($this->param);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 格式化 fields
    |
    |-------------------------------------------------------------------------------
    */
    public function fields(){
        $attribute          = $this->attribute();
        return [
            'username'      =>$attribute->username,
            'phone'         =>$attribute->phone,
            'email'         =>$attribute->email,
            'nickname'      =>$attribute->nickname,
            'sex'           =>$attribute->sex,
            'birthday'      =>$attribute->birthday,
            'sfz'           =>$attribute->sfz,   
        ];
    }
}