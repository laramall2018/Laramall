<?php namespace Phpstore\Order;
/**
 * Created by PhpStorm.
 * User: swh
 * Date: 15/9/11
 * Time: 上午9:59
 */

use Phpstore\Grid\TableData;
use Phpstore\Grid\Grid;
use Phpstore\Grid\Page;
use Phpstore\Grid\Common;
use Phpstore\Base\Goodslib; 
use App\User;
use App\Models\Order;
use App\Models\OrderGoods;
use App\Models\Goods;
use App\Models\Shipping;
use App\Models\Payment;
use App\Models\Region;
use App\Models\ArticleCat;
use DB;


class OrderLog{

    public $log;
    public $add_time;
    public $username;
    public $order_sn;



    /*
    |----------------------------------------------------------------------------
    |
    |  构造函数
    |
    |----------------------------------------------------------------------------
    */
    function __construct(){

       
    }


    /*
    |----------------------------------------------------------------------------
    |
    |   添加日志
    |
    |----------------------------------------------------------------------------
    */
    public function log(){

    	$row 			= [

    						'order_sn'	=>$this->order_sn,
    						'add_time'	=>time(),
    						'username'	=>$this->username,
    						'log'		=>$this->log
    	];

    	DB::table('order_log')->insert($row);
    }

}