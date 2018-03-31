<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Phpstore\Repository\ShippingRepository;

class Shipping extends Model{

	use ShippingRepository;
	protected $table = 'shipping';


	/*
    |-------------------------------------------------------------------------------
    |
    |   获取系统的默认配送方式
    |
    |-------------------------------------------------------------------------------
    */
    public static function def(){

    	return Shipping::where('shipping_code','sf_express')->first();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   和RegionShipping模型 为一对多关联
    |
    |-------------------------------------------------------------------------------
    */
    public function region_shipping(){

        return $this->hasMany(RegionShipping::class,'shipping_id','id');
    }

}