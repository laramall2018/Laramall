<?php

namespace LaraStore\Forms\OrderReturn;

use App\Http\Controllers\Api\ApiController as Api;
use App\User;
use Auth;
use App\Models\OrderReturn;
use LaraStore\Forms\Form;

class DeleteForm extends Form{

	public $api;
	/*
    |-------------------------------------------------------------------------------
    |
    | 注册表单验证规则
    |
    |-------------------------------------------------------------------------------
    */
    protected $rules = [
        
    ];


    /*
    |-------------------------------------------------------------------------------
    |
    | 注册表单验证规则提示信息
    |
    |-------------------------------------------------------------------------------
    */
    protected $messages = [
       	
    ];


    /*
    |-------------------------------------------------------------------------------
    |
    | 构造函数
    |
    |-------------------------------------------------------------------------------
    */
    public function __construct(Api $api){
       $this->api               = $api;
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
    |  验证数据
    |
    |-------------------------------------------------------------------------------
    */
    public function isEmpty(){

        $model            =  OrderReturn::find($this->id);
        return empty($model)? true :false;
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  退货单允许被删除
    |
    |-------------------------------------------------------------------------------
    */
    public function canDelete(){
        $model          = OrderReturn::find($this->id);
        return (in_array($model->return_status,[0,1]))? true :false;
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  验证数据
    |
    |-------------------------------------------------------------------------------
    */
    public function isValid(){

        return ($this->auth() && (!$this->isEmpty()) && ($this->canDelete())) ?  true : false;
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
        $return_list        = $user->order_return()->get();
        $order_list         = $user->presenter()->canReturnOrderList;
    	return $this->api->respond(['data'=>compact('tag','info','return_list','order_list')]);
    	
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

        if($this->isEmpty()){
            $info               = '模型不存在';
            return $this->api->respondCommonError($info);
        }

        if(!$this->canDelete()){
            $info               = '退货单仅仅在审核阶段才可以被删除';
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
         $model     = OrderReturn::find($this->id);
         //设置订单状态
         $model->order->presenter()->update(['return_status'=>0]);
         //删除退货单
         $model->delete();
    }
}