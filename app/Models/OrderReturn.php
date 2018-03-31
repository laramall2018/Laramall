<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Phpstore\Repository\OrderReturnRepository;

class OrderReturn extends Model{

	use OrderReturnRepository;
	protected $table           = 'order_return';
    protected $fillable        = [
                                    'order_id',
                                    'username',
                                    'user_id',
                                    'type',
                                    'return_note',
                                    'return_amount',
                                    'bank_name',
                                    'bank_account',
                                    'reg_from',
                                    'add_time',
                                    'ip',
                                    'return_status',
    ]; 
    protected $appends          = ['orderSn','createTime','statusFormat','url'];
	/*
    |-------------------------------------------------------------------------------
    |
    | 一对一关联  退货单和订单  一个订单只允许退货一次
    |
    |-------------------------------------------------------------------------------
    */
    public function order(){

    	return $this->belongsTo(Order::class,'order_id','id');
    }

}