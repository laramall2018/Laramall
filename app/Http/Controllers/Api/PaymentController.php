<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Order;

class PaymentController extends ApiController
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
    | 获取支付方式列表
    |
    |-------------------------------------------------------------------------------
    */
    public function index(){

        $payment_list           = Payment::getList();
        $tag                    = $this->tag;
        $info                   = $this->info;
        return $this->respond(['data'=>compact('tag','info','payment_list')]);

    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 获取支付按钮
    |
    |-------------------------------------------------------------------------------
    */
    public function paybtn(){

        $pay_id             = request()->pay_id;
        $order_id           = request()->order_id;

        $payment            = Payment::find($pay_id);
        $order              = Order::find($order_id);

        if(empty($payment) || empty($order)){
            $info           = '异常操作';
            return $this->respondCommonError($info);
        }
        $tag                = $this->tag;
        $info               = $this->info;
        $pay_btn            = $payment->get_pay_btn($order);
        return $this->respond(['data'=>compact('tag','info','pay_btn')]);
    }

}
