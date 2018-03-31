<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\Order;
use App\User;
use App\Models\Fp;
use LaraStore\Forms\OrderForm;
use LaraStore\Forms\OrderDeleteForm;
use LaraStore\Forms\Order\MergeForm;

class OrderController extends ApiController
{
    

    public $tag;
    public $info;
    /*
    |-------------------------------------------------------------------------------
    |
    | 构造函数
    |
    |-------------------------------------------------------------------------------
    */
    public function __construct(){

        $this->tag          = 'success';
        $this->info         = 'success';
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 确认下订单
    |
    |-------------------------------------------------------------------------------
    */
    public function done(){
        //未登录不让购物
        if(!Auth::check('user')){
            return $this->notLoginError();
        }
        $user               = Auth::user('user');
        //未选择默认配送地址
        if(!$user->default_address()){
            return $this->notAddressError();
        }
        //购物车中没有产品
        if($user->number() == 0){
            return $this->cartEmptyError();
        }
        //获取参数
        $param              = request()->param;
        $param              = json_decode($param);
        //获取所有参数
        $pay_id             = $param->pay_id;
        $shipping_id        = $param->shipping_id;
        $card_sn            = $param->card_sn;
        $fp_type            = $param->fp_type;
        $fp_title           = $param->fp_title;
        //生成订单
        $order_id           = Order::createOrder(compact('pay_id','shipping_id','card_sn'));
        //生成发票信息
        $fp                 = Fp::makeItem(compact('fp_type','fp_title','order_id'));
        //把购物车中被选中的商品移动订单商品模型中去
        $order              = Order::find($order_id);
        $order->cartToOrderGoods();
        $order_goods        = $order->order_goods;
        $tag                = $this->tag;
        $info               = $this->info;

        return $this->respond(['data'=>compact('tag','info','order','fp','order_goods')]);

    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取用户的所有订单
    |
    |-------------------------------------------------------------------------------
    */
    public function index(){
        $form           = new OrderForm($this);
        return ($form->auth())? $form->successRespond(): $form->errorRespond();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 删除订单
    |
    |-------------------------------------------------------------------------------
    */
    public function delete(){
        $form           = new OrderDeleteForm($this);
        return ($form->isValid())?$form->successRespond():$form->errorRespond();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  合并订单
    |
    |-------------------------------------------------------------------------------
    */
    public function merge(){

        $form       = new MergeForm($this);
        return ($form->isValid()) ? $form->successRespond() : $form->errorRespond();
    }



}
