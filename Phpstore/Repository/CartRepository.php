<?php

namespace Phpstore\Repository;
use Auth;

trait CartRepository{


	/*
    |-------------------------------------------------------------------------------
    |
    | 返回当前登录用户购物车中商品数量
    |
    |-------------------------------------------------------------------------------
    */
    public static function number(){

    	if(!Auth::check('user')){

    		return 0;
    	}

    	$model 			= new static;

    	return $model->where('user_id',Auth::user('user')->id)
    				 ->sum('goods_number');
    	
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 返回当前登录用户的购物车总被选中的商品数量
    |
    |-------------------------------------------------------------------------------
    */
    public static function checked_number(){

        if(!Auth::check('user')){

            return 0;
        }

        $model 				= new static;

        return $model->where('user_id',Auth::user('user')->id)
        			 ->where('is_checked',1)
        			 ->sum('goods_number');
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 返回购物车单条记录的总价格
    |
    |-------------------------------------------------------------------------------
    */
    public function total(){

    	return $this->goods_number * $this->shop_price ;
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 返回登录用户购物车中商品总价格
    |
    |-------------------------------------------------------------------------------
    */
    public static function amount(){

    	if(!Auth::check('user')){

    		return 0;
    	}

    	$model 				= new static;
    	$res 				= $model->where('user_id',Auth::user('user')->id)
                          			->where('is_checked',1)
                          			->get();

    	$amount 			= 0;

    	foreach($res as $cart){

    		$amount += $cart->total();
    	}

    	return $amount;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 返回登录用户购物车中商品总价格
    |
    |-------------------------------------------------------------------------------
    */
    public static function amountAll(){

        if(!Auth::check('user')){

            return 0;
        }

        $model              = new static;
        $res                = $model->where('user_id',Auth::user('user')->id)
                                    ->get();

        $amount             = 0;

        foreach($res as $cart){

            $amount += $cart->total();
        }

        return $amount;
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 获取当前登录用户的购物车商品列表    
    |
    |-------------------------------------------------------------------------------
    */
    public static function cart(){

        if(!Auth::check('user')){

            return false;
        }

        $model 					= new static;
        return  $model->where('user_id',Auth::user('user')->id)->get();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 购物车中当前商品数量 + 1
    |
    |-------------------------------------------------------------------------------
    */
    public function add(){

        if(!Auth::check('user')){

            return false;
        }

        $total                      = intval($this->goods_number) + 1;
        $goods_number               = $this->goods->goods_number;

        if($total < $goods_number){

            $this->goods_number     += 1;
            $this->save();
        }
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 购物车中当前商品数量 - 1
    |
    |-------------------------------------------------------------------------------
    */
    public function sub(){

        if(!Auth::check('user')){

            return false;
        }

        $total                    = intval($this->goods_number);
       
        if($total > 1){

            $this->goods_number  -= 1;
            $this->save();
        }
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 购物车商品被选中
    |
    |-------------------------------------------------------------------------------
    */
    public function doChecked(){

        $this->is_checked = 1;
        $this->save();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 让购物车中商品未被选中
    |
    |-------------------------------------------------------------------------------
    */
    public function unChecked(){

        $this->is_checked   = 0;
        $this->save();
    }


    

}