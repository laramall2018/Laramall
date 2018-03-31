<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Phpstore\Repository\AddressRepository;

class UserAddress extends Model{

    use AddressRepository;
	protected $table           = 'user_address';
    protected $fillable        = [
                                    'consignee',
                                    'email',
                                    'phone',
                                    'address',
                                    'country',
                                    'province',
                                    'city',
                                    'district',
                                    'user_id',
                                 ];
    protected $appends         = [
                                    'isDefault',
                                    'countryName',
                                    'provinceName',
                                    'cityName',
                                    'districtName',
                                    'addressName',
                                 ];


	
	/*
    |-------------------------------------------------------------------------------
    |
    | 一对多的关系 一个用户会有多个地址 一个地址属于某个用户
    |
    |-------------------------------------------------------------------------------
    */
    public function user(){

    	return $this->belongsTo('App\User','user_id','id');
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取国家省会城市地区
    |
    |-------------------------------------------------------------------------------
    */
    public function country(){

    	return Region::find($this->country)->region_name;
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 获取国家省会城市地区
    |
    |-------------------------------------------------------------------------------
    */
    public function province(){

    	return Region::find($this->province)->region_name;
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 获取国家省会城市地区
    |
    |-------------------------------------------------------------------------------
    */
    public function city(){

    	return Region::find($this->city)->region_name;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取国家省会城市地区
    |
    |-------------------------------------------------------------------------------
    */
    public function district(){

    	return Region::find($this->district)->region_name;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取详细地址
    |
    |-------------------------------------------------------------------------------
    */
    public function address(){

    	return $this->country() . $this->province() . $this->city() . $this->district() .' '.$this->address;
    }
}