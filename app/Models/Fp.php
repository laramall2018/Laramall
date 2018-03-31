<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Phpstore\Repository\FpRepository;

class Fp extends Model
{	
	use FpRepository;
    protected $table  			= 'fp';
    protected $fillable 		= ['fp_type','fp_content','fp_title','order_id','user_id'];
    protected $appends 			= ['fpGoodsContent','fpTypeName'];

    

    /*
    |-------------------------------------------------------------------------------
    |
    | 发票和订单的关系  一对一 
    |
    |-------------------------------------------------------------------------------
    */
    public function  order(){

    	return $this->belongsTo(Order::class,'order_id','id');
    }
}
