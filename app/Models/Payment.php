<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Phpstore\Repository\PaymentRepository;
use LaraStore\Cache\CacheCommon;
class Payment extends Model{

	use PaymentRepository,CacheCommon;
	protected $table           = 'payment';
    protected $appends         = ['paymentIcon'];


	/*
    |-------------------------------------------------------------------------------
    |
    |   获取系统的默认的支付方式
    |
    |-------------------------------------------------------------------------------
    */
    public static function def(){

    	return Payment::where('pay_code','alipay')->first();
    }

}