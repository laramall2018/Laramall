<?php

namespace Phpstore\Repository;
use App\Models\Cart;
use App\Models\RegionShipping;
use App\Models\UserAddress;

trait ShippingRepository{


  /*
  |-------------------------------------------------------------------------------
  |
  | 使用trait 让模型Shipping 拥有业务逻辑所需的方法
  | 获取快递运费 当商品价格满足一定的额度的时候 免运费
  |
  |-------------------------------------------------------------------------------
  */
  public function getFee($address_id){

  		//如果没设置额度 则直接返回运费
  		if($this->free_total <= 0){

  			return $this->getRegionShipping($address_id);
  		}

  		//如果设置了额度 并且购物车中商品总价格满足额度 则减免运费
  		$cart_amount  		= Cart::amount();
  		if($cart_amount >=  $this->free_total){

  			//免运费
  			return 0;
  		}

  		//返回运费
  		return $this->getRegionShipping($address_id);
  }


  /*
  |-------------------------------------------------------------------------------
  |
  | 使用trait 让模型Shipping 拥有业务逻辑所需的方法
  | 输出下拉选项
  |
  |-------------------------------------------------------------------------------
  */
  public static function option_list(){

      $str        = '';
      $instance   = new static;

      foreach($instance->where('tag',1)->get() as $item){

          $str  .= '<option value="'.$item->id.'">'.$item->shipping_name.'</option>';
      }

      return $str;
  }


  /*
  |-------------------------------------------------------------------------------
  |
  | 使用trait 让模型Shipping 拥有业务逻辑所需的方法
  | 获取地区的配送运费
  |
  |-------------------------------------------------------------------------------
  */
  public function getRegionShipping($address_id){

      $address                  = UserAddress::findOrFail($address_id);
      //地址模型为空
      if(empty($address)){

          return $this->fee;
      }
      //获取当前运费方式在地区运费列表中的记录
      $region_shipping          =  $this->region_shipping()->where('region_id',$address->province)->first();
      //如果不存在地区运费                                            
      if(empty($region_shipping)){

         return $this->fee;
      }

      return $region_shipping->fee;

  }
}