<?php

namespace LaraStore\Forms\OrderReturn;

use App\Http\Controllers\Api\ApiController as Api;
use App\User;
use Auth;
use App\Models\OrderReturn;
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

        'order_id'   =>'required|numeric|min:1',
        'type'       =>'required',
        'username'   =>'required',
        'return_note'=>'required',
    ];


    /*
    |-------------------------------------------------------------------------------
    |
    | 注册表单验证规则提示信息
    |
    |-------------------------------------------------------------------------------
    */
    protected $messages = [

        'order_id.required'   =>'订单必须',
        'order_id.numeric'    =>'订单编号必须为数字',
        'order_id.min'        =>'最小编号为1',
        'type.required'       =>'类型必须',
        'username.required'   =>'用户名称必须',
        'return_note.required'=>'退货说明必须',
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
        $return_list  	= $user->order_return()->get();
        $order_list     = $user->presenter()->canReturnOrderList;
    	return $this->api->respond(['data'=>compact('tag','info','return_list')]);
    	
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
    | 转化json格式
    |
    |-------------------------------------------------------------------------------
    */
    public function attributes(){
        return json_decode($this->param);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 转化数组
    |
    |-------------------------------------------------------------------------------
    */
    public function fields(){
        return [
            'order_id'      =>$this->attributes()->order_id,
            'type'          =>$this->attributes()->type,
            'username'      =>$this->attributes()->username,
            'return_note'   =>$this->attributes()->return_note,
            'bank_name'     =>$this->attributes()->bank_name,
            'bank_account'  =>$this->attributes()->bank_account,
            'return_amount' =>$this->attributes()->return_amount,
        ];
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
         $arr   = [
            'ip'            =>request()->ip(),
            'reg_from'      =>'pc版本',
            'add_time'      =>time(),
            'return_status' =>1,
            'user_id'       => Auth::user('user')->id,
         ];
         $data  = array_merge($this->fields(),$arr);
         $model = OrderReturn::create($data);
         $model->order->presenter()->update(['return_status'=>1]);
    }
}
