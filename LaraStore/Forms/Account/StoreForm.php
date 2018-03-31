<?php

namespace LaraStore\Forms\Account;

use App\Http\Controllers\Api\ApiController as Api;
use App\User;
use Auth;
use App\Models\Account;
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

        'type'      =>'required',
        'amount'    =>'required|numeric|min:1',
        'payment'   =>'required',
        'user_note' =>'required',
    ];


    /*
    |-------------------------------------------------------------------------------
    |
    | 注册表单验证规则提示信息
    |
    |-------------------------------------------------------------------------------
    */
    protected $messages = [
        'type.required'     	    =>'类型必须',
        'amount.required'  	        =>'金额必须',
        'amount.min'                =>'金额至少大于1',
        'amount.numeric'            =>'金额必须是数字',
        'payment.required'          =>'支付方式必须',
        'user_note.required'        =>'用户备注必须',
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
        $account_list  	= $user->account()->get();
        $money          = $user->presenter()->moneyFormat;
    	return $this->api->respond(['data'=>compact('tag','info','account_list','money')]);
    	
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
            'type'          =>$this->type,
            'amount'        =>$this->amount,
            'payment'       =>$this->payment,
            'user_note'     =>$this->user_note,
            'ip'            =>request()->ip(),
            'add_time'	    =>time(),
            'username'      =>Auth::user('user')->username,
         ];
         Account::create($data);
    }
}
