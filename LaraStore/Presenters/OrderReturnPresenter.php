<?php

namespace LaraStore\Presenters;
use App\Models\OrderReturn;
use App\User;
use Auth;
use LaraStore\Presenters\PresenterTrait;

class OrderReturnPresenter{

	use PresenterTrait;
	protected $model;
	/*
    |-------------------------------------------------------------------------------
    |
    |  构造函数
    |
    |-------------------------------------------------------------------------------
    */
    public function __construct(OrderReturn $model){

    	$this->model 		= $model;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  获取订单号
    |
    |-------------------------------------------------------------------------------
    */
    public function order_sn(){
    	return ($this->model->order)? $this->model->order->order_sn : false;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  获取预览退货单的链接
    |
    |-------------------------------------------------------------------------------
    */
    public function url(){
    	return url('auth/return/preview/'.$this->model->id);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  退款金额
    |
    |-------------------------------------------------------------------------------
    */
    public function return_amount_format(){
    	return money_format('￥%i', $this->model->return_amount);
    }
}