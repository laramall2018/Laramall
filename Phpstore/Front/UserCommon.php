<?php namespace Phpstore\Front;

use Auth;
use App\Models\Order;
use App\Models\OrderGoods;
use App\User;
use HTML;
use DB;
/*
|-------------------------------------------------------------------------------
|
|   前台和用户相关的处理控制类
|
|-------------------------------------------------------------------------------
|
|   tableDataInit  	    --------------- 初始化tableData实例 并赋值给grid实例
|   setTableDataCol		--------------- 设置tabledata实例需要显示的数据库字段
|   getData 		    --------------- 根据指定的字段 获取表格所需要显示的所有数据
|   getTableData($info) --------------- 根据返回的json格式数据 初始化新的tableData实例
|   searchData          --------------- grid模板页面 需要的搜索表单配置数组
|   searchInfo 			--------------- grid模板页面 ajax操作函数 需要的json格式参数
|                                       ps.ui.grid(ajax_url,_token ,json)
|   FormData            --------------- 生成添加商品时候的表单数据信息
|   EditData            --------------- 编辑商品时候生成表单的数组信息
|   delete_goods_image  --------------- 删除商品图片
|   softdelAction       --------------- 批量回收站操作
|   deleteAction        --------------- 批量删除操作
|
|-------------------------------------------------------------------------------
*/
class UserCommon{

	



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
	|  检测前台用户是否登录
	|
	|----------------------------------------------------------------------------
	*/
	public function is_front(){

		return (Auth::check('user'))? true:false;
	}


	/*
	|----------------------------------------------------------------------------
	|
	|  获取用户的订单列表
	|
	|----------------------------------------------------------------------------
	*/
	public function get_order_list(){

		if(!$this->is_front()){

			return false;
		}


		$row 			= Order::where('user_id',Auth::user()->id)
							   ->orderBy('id','desc')
							   ->paginate(5);

		foreach($row as $key=>$value){

			$row[$key]['status_str'] 	= $this->get_order_status($value->id);
		}

		return $row;
	}


	/*
	|----------------------------------------------------------------------------
	|
	|  获取订单的状态
	|
	|----------------------------------------------------------------------------
	*/
	public function get_order_status($order_id){

		 $order 				= Order::find($order_id);

		 $str 					= '';

		 $order_status 			= $order->order_status;
		 $pay_status 			= $order->pay_status;
		 $shipping_status 		= $order->shipping_status;
		 $return_status 		= $order->return_status;
		 $cancel_status 	    = $order->cancel_status;

		 //状态数组
		 $order_status_arr 		= ['未确认','已确认'];
		 $pay_status_arr 		= ['未支付','已支付'];
		 $shipping_status_arr 	= ['未发货','已发货'];


		 if($cancel_status == 1){

		 	 $str 				= '订单已取消';
		 	 return $str;
		 }
		 else{

		 	 if($return_status == 1){


		 	 		$str 		= '退货申请中';
		 	 		return $str;
		 	 }
		 	 elseif($return_status == 2){

		 	 	    $str 		= '退货已批准';
		 	 	    return $str;
		 	 }
		 	 elseif($return_status == 3){

		 	 	    $str 		= '退货完成';
		 	 	    return $str;
		 	 }
		 	 else{

		 	 		//未发生退货 也未取消订单
		 	 		$str 		= 	$order_status_arr[$order_status]
		 	 					   .$pay_status_arr[$pay_status]
		 	 					   .$shipping_status_arr[$shipping_status];
		 	 }
		 }

		 return $str;


	}

	/*
	|----------------------------------------------------------------------------
	|
	|  获取订单中的产品列表
	|
	|----------------------------------------------------------------------------
	*/
	public function get_order_goods_list($id){

		$order 		= Order::find($id);
		if(empty($order)){

			return false;
		}

		$res 							= OrderGoods::where('order_id',$id)->get();
		$common 						= new \Phpstore\Base\Common();
		$cart_common 					= new \Phpstore\Front\CartCommon();

		foreach($res as $key=>$value){

				$res[$key]['url'] 		= $common->build_goods_url($value->goods_id);
		 		$res[$key]['total']  	= $value->shop_price * $value->goods_number;
		 		$res[$key]['thumb']		= $cart_common->get_goods_thumb($value->goods_id);

		}

		return $res;

	}

	/*
	|----------------------------------------------------------------------------
	|
	|  获取用户中心的退货单信息
	|
	|----------------------------------------------------------------------------
	*/
	public function get_order_return_list(){

		if(!Auth::check('user')){

			return false;
		}

		$res 				= DB::table('order_return')
								->where('user_id',Auth::user('user')->id)
								->paginate(20);

		return $res; 
	}

}