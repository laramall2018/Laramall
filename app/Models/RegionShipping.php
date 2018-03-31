<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegionShipping extends Model
{	
	//对应的数据表格
    protected $table  = 'region_shipping';



    /*
    |-------------------------------------------------------------------------------
    |
    |   和Shipping 模型为多对一的关系
    |
    |-------------------------------------------------------------------------------
    */
    public function shipping(){

    	return $this->belongsTo(Shipping::class,'shipping_id','id');
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   和Region 模型为多对一关系
    |
    |-------------------------------------------------------------------------------
    */
    public function region(){

    	return $this->belongsTo(Region::class,'region_id','region_id');
    }
}
