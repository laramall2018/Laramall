<?php

namespace LaraStore\Presenters;

use App\User;
use LaraStore\Presenters\PresenterTrait;
use App\Models\{
                    Card,
                    Account,
                    Order
};

class UserPresenter{

	use PresenterTrait;
	protected $user;
	/*
    |-------------------------------------------------------------------------------
    |
    |  构造函数
    |
    |-------------------------------------------------------------------------------
    */
    public function __construct(User $user){
    	$this->user 		= $user;
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |  用户余额格式化
    |
    |-------------------------------------------------------------------------------
    */
    public function moneyFormat(){

    	return money_format('￥%i', $this->user->money());
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |  获取用户可以用于申请退款的订单列表
    |
    |-------------------------------------------------------------------------------
    */
    public function canReturnOrderList(){

        if($this->user->order()->get()){
            return $this->user->order()->where('pay_status',1)->where('return_status',0)->get();
        }
        return false;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  判断给定的礼品卡串号是否 可以用于支付商品购物车中被选中的所有商品总金额
    |
    |-------------------------------------------------------------------------------
    */
    public function canCardPay($card_sn){

        //购物车中被选中的商品总金额
        $cartAmount         = $this->user->amount();
        $card               = Card::searchBy($card_sn);
        //礼品卡为空 则直接返回false
        if(empty($card)){

            return false;
        }
        
        $cardAmount         = $card->price;
        //礼品卡总金额大于购物车中被选中商品总金额 则禁止
        if($cardAmount >= $cartAmount){

            return false;
        }

        return true;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  生成账号消费金额记录
    |
    |-------------------------------------------------------------------------------
    */
    public function accountPay($order){

        $data       = [

                'username'  => $this->user->username,
                'type'      =>1,
                'amount'    =>$order->order_amount,
                'payment'   =>'余额支付',
                'user_note' =>'余额用于支付订单金额，订单号：'.$order->order_sn,
                'add_time'  => time(),
                'ip'        => request()->ip(),
                'pay_tag'   => 1,
        ];

        Account::create($data);
    }
    
}