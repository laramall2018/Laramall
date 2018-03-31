<?php

namespace LaraStore\Presenters;
use App\Models\Account;
use App\User;
use Auth;

class AccountPresenter{

	protected $account;


	/*
    |-------------------------------------------------------------------------------
    |
    |  构造函数
    |
    |-------------------------------------------------------------------------------
    */
    public function __construct(Account $account){
    	
    	$this->account     = $account;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  显示符号 充值 +  提现 -
    |
    |-------------------------------------------------------------------------------
    */
    public function typeTag(){
        if($this->account->type == 1){
            return '-';
        }
        return '+';
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  魔术方法
    |
    |-------------------------------------------------------------------------------
    */
    public function __get($property){
        return (method_exists($this, $property))? call_user_func([$this,$property]) : false;
    }


}