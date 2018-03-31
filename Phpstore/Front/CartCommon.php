<?php namespace Phpstore\Front;

use Auth;
use App\Models\Cart;
use App\Models\Goods;
use App\Models\GoodsAttr;
use App\Models\UserAddress;
use App\Models\Shipping;
use App\Models\Payment;
use App\Models\Order;
use App\Models\Region;
use App\Models\OrderGoods;
use DB;
use Session;
use HTML;
use Form;
use Request;
use Phpstore\Alipay\Common as Alipay;

/*
|-------------------------------------------------------------------------------
|
|   处理购物车
|
|-------------------------------------------------------------------------------
*/
class CartCommon{

	



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
	|  获取商品信息
	|
	|----------------------------------------------------------------------------
	*/
	public function get_goods_info($goods_id){

		$goods 			= Goods::find($goods_id);

		if($goods){

			return $goods;
		}

		return false;

	}

	/*
	|----------------------------------------------------------------------------
	|
	|  获取商品的属性字符串
	|
	|----------------------------------------------------------------------------
	*/
	public function get_goods_attr($ids){

		$str 		= '';

		if(empty($ids)){

			return $str;
		}

		foreach($ids as $id){

			$model     			= GoodsAttr::find($id);

			if(empty($model)){

				continue;
			}

			$str 			    = $str . $model->attr_value.' ';
		}

		return $str;
	}


	/*
	|----------------------------------------------------------------------------
	|
	|  获取商品的缩略图
	|
	|----------------------------------------------------------------------------
	*/
	public function get_goods_thumb($goods_id){

		$res 			= DB::table('goods_gallery')->where('goods_id',$goods_id)->first();

		if($res){

			return $res->thumb;
		}

		return false;
	}

	/*
	|----------------------------------------------------------------------------
	|
	|  获取购物车清单
	|
	|----------------------------------------------------------------------------
	*/
	public function get_cart_list(){

		 $row 		= [];

		 if(!$this->is_front()){

		 	return $row;
		 }

		 $res 		= Cart::where('user_id',Auth::user()->id)
		 				  ->get();

		 if(empty($res)){

		 	return $row;
		 }

		 $common 	= new \Phpstore\Base\Common();

		 foreach($res as $key=>$value){

		 		$res[$key]['url'] 		= $common->build_goods_url($value->goods_id);
		 		$res[$key]['total']  	= $value->shop_price * $value->goods_number;
			 }

		 return $res;
	}

	/*
	|----------------------------------------------------------------------------
	|
	|  获取购物车中总金额
	|
	|----------------------------------------------------------------------------
	*/
	public function get_cart_total(){

		$sum 					= 0;

		if(!$this->is_front()){

		 	return $sum;
		 }

		 $res 					= Cart::where('user_id',Auth::user()->id)
		 				  			  ->get();

		 if(empty($res)){

		 	return $sum;
		 }

		 foreach($res as $item){

		 	  $sum 		= $sum + $item->shop_price *$item->goods_number;
		 }	


		 return $sum;

	}


	/*
    |-------------------------------------------------------------------------
    |
    |  获取购物车商品数量
    |
    |-------------------------------------------------------------------------
    */
    public function get_cart_number(){

        if(!Auth::check()){

            return 0;
        }

        $res            = DB::table('cart')
                            ->where('user_id',Auth::user()->id)
                            ->sum('goods_number');
        return $res;
    }

    /*
    |-------------------------------------------------------------------------
    |
    |  把商品加入购物车
    |
    |-------------------------------------------------------------------------
    */
    public function add_to_cart($goods_id,$goods_attr_ids,$goods_number){

    	$goods              			= $this->get_goods_info($goods_id);
        $goods_attr         			= $this->get_goods_attr($goods_attr_ids);
        $thumb              			= $this->get_goods_thumb($goods_id);

        //检测商品在购物车中是否存在
        if(empty($goods_attr)){

        	$cart 					    = Cart::where('session_id',Session::getId())
        									  ->where('user_id',Auth::user()->id)
        									  ->where('goods_id',$goods_id)
        									  ->first();
        }
        else{

        	$cart 					    = Cart::where('session_id',Session::getId())
        									  ->where('user_id',Auth::user()->id)
        									  ->where('goods_id',$goods_id)
        									  ->where('goods_attr',$goods_attr)
        									  ->first();
        }


        //存在 则更新购物车
        if($cart){

        	$cart->goods_number 		+= $goods_number;
        	$cart->save();
        }
        else{

        	$data               		= [
                                    		'session_id'        => Session::getId(),
                                    		'user_id'           => Auth::user()->id,
                                    		'goods_id'          =>$goods_id,
                                    		'goods_name'        =>$goods->goods_name,
                                    		'goods_sn'          =>$goods->goods_sn,
                                    		'goods_name'        =>$goods->goods_name,
                                    		'market_price'      =>$goods->market_price,
                                    		'shop_price'        =>$goods->shop_price,
                                    		'goods_number'      =>$goods_number,
                                    		'goods_attr'        =>$goods_attr,
                                    		'thumb'             =>$thumb

           ];

        	DB::table('cart')->insert($data);
        }
    }

    /*
    |-------------------------------------------------------------------------
    |
    |  根据地址类型选择地址信息
    |
    |-------------------------------------------------------------------------
    */
    public function get_region($region_type){

    	if(!in_array($region_type,[0,1,2])){

    			return false;
    	}

    	$res 			= DB::table('region')->where('region_type',$region_type)->get();

    	return $res;
    }

    /*
    |-------------------------------------------------------------------------
    |
    |  获取用户的地址信息
    |
    |-------------------------------------------------------------------------
    */
    public function get_address_list(){

    	if(!$this->is_front()){

    		return false;
    	}

    	$row 		= UserAddress::where('user_id',Auth::user()->id)->get();

    	if(empty($row)){

    		return false;
    	}

    	foreach($row as $key=>$value){

    		$row[$key]['country_str'] 			= $this->get_region_name($value->country);
    		$row[$key]['province_str']			= $this->get_region_name($value->province);
    		$row[$key]['city_str']  			= $this->get_region_name($value->city);
    		$row[$key]['district_str'] 			= $this->get_region_name($value->district);

    	}

    	return $row;
    }


    /*
    |-------------------------------------------------------------------------
    |
    |  获取地区名称
    |
    |-------------------------------------------------------------------------
    */
    public function get_region_name($region_id){

    		$region 			= Region::find($region_id);

    		if($region){

    			return $region->region_name;
    		}

    		return '';
    }


    /*
    |-------------------------------------------------------------------------
    |
    |  获取支付方式
    |
    |-------------------------------------------------------------------------
    */
    public function get_payment_list(){

    	 $res 			= DB::table('payment')->where('tag',1)->get();

    	 return $res;
    }


    /*
    |-------------------------------------------------------------------------
    |
    |  获取配送方式列表
    |
    |-------------------------------------------------------------------------
    */
    public function get_shipping_list(){

    	return DB::table('shipping')->where('tag',1)->get();
    }

    /*
    |-------------------------------------------------------------------------
    |
    |  获取配送方式列表
    |
    |-------------------------------------------------------------------------
    */
    public function create_order($address_id,$shipping_id,$pay_id){

         if(!Auth::check('user')){

            return false;
         }
         $user              = Auth::user('user');
         //创建订单编号       
         $order_sn          = $this->create_order_sn();
         $address           = UserAddress::find($address_id);
         $shipping          = Shipping::find($shipping_id);
         $pay               = Payment::find($pay_id);
         $goods_amount      = $user->amount();
         $order_amount      = $goods_amount + $shipping->fee;

         $order_id          = 0;

         $data              =       [

                                        'order_sn'      =>$order_sn,
                                        'user_id'       =>Auth::user()->id,
                                        'order_status'  =>0,
                                        'shipping_status'=>0,
                                        'pay_status'     =>0,
                                        'consignee'      =>$address->consignee,
                                        'country'        =>$address->country,
                                        'province'       =>$address->province,
                                        'city'           =>$address->city,
                                        'district'       =>$address->district,
                                        'address'        =>$address->address,
                                        'phone'          =>$address->phone,
                                        'email'          =>$address->email,
                                        'shipping_id'    =>$shipping_id,
                                        'shipping_name'  =>$shipping->shipping_name,
                                        'pay_id'         =>$pay_id,
                                        'pay_name'       =>$pay->pay_name,
                                        'goods_amount'   =>$goods_amount,
                                        'shipping_fee'   =>$shipping->fee,
                                        'order_amount'   =>$order_amount,
                                        'add_time'       =>time(),
                                        'ip'             =>Request::getClientIp(),

                                    ];


        $order_id           = DB::table('order_info')->insertGetId($data);

        return $order_id;
    }


    /*
    |-------------------------------------------------------------------------
    |
    |  生成订单编号
    |
    |-------------------------------------------------------------------------
    */
    function create_order_sn()
    {
        /* 选择一个随机的方案 */
        mt_srand((double) microtime() * 1000000);
        return date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
    }


    /*
    |-------------------------------------------------------------------------
    |
    |  把购物车中产品写入到订单产品表中
    |
    |-------------------------------------------------------------------------
    */
    public function cart_to_order_goods($order_id){

         if(!Auth::check('user')){

            return false;
         }

         $user          = Auth::user('user');
         $order_id      = intval($order_id);

         if($order_id == 0){

            return false;
         }

        
         foreach($user->cart()->where('is_checked',1)->get() as $item){

                $data   = [
                            'order_id'          =>$order_id,
                            'goods_id'          =>$item->goods_id,
                            'goods_name'        =>$item->goods_name,
                            'goods_sn'          =>$item->goods_sn,
                            'goods_number'      =>$item->goods_number,
                            'shop_price'        =>$item->shop_price,
                            'goods_attr'        =>$item->goods_attr,
                            'market_price'      =>$item->market_price
                ];

                DB::table('order_goods')->insert($data);
         }

         //删除购物车
         Cart::where('user_id',Auth::user()->id)->where('is_checked',1)->delete();
    }


    /*
    |-------------------------------------------------------------------------
    |
    |  生成支付按钮
    |
    |-------------------------------------------------------------------------
    */
    public function get_pay_btn($order){

        $payment        = Payment::find($order->pay_id);
        $str            = '';

        if(empty($payment)){

            return $str;
        }

        if($payment->pay_code == 'alipay'){

            $str = $this->alipay_btn($order);
        }
        else{

            $str = $payment->pay_name.'暂时没开启';
        }


        return $str; 

    }


    /*
    |-------------------------------------------------------------------------
    |
    |  生成支付宝的支付按钮
    |
    |-------------------------------------------------------------------------
    */
    public function alipay_btn($order){

        if(empty($order)){

            return false;
        }

        $res                    = DB::table('order_goods')
                                    ->where('order_id',$order->id)
                                    ->first();


        $alipay                 = new Alipay();

        $row                    = [

            'WIDout_trade_no'   =>$order->order_sn,
            'WIDsubject'        =>$res->goods_name,
            'WIDtotal_fee'      =>$order->order_amount,
            'WIDbody'           =>$res->goods_name,
            'WIDshow_url'       =>url('goods/'.$res->goods_id),
            'WIDit_b_pay'       =>'',
            'WIDextern_token'   =>'',

        ];


        return $alipay->get_pay_btn($row);

    }

    /*
    |-------------------------------------------------------------------------
    |
    |  获取订单中产品
    |
    |-------------------------------------------------------------------------
    */
    public function get_order_row($order){

        $order_id           = $order->id;

        $row                = DB::table('order_goods')->where('order_id',$order_id)->first();

        $order_name         = $row->goods_name;
        $order_url          = url('goods/'.$row->goods_id);

        return [ 'name'=>$order_name,'url'=>$order_url ];
    }


    /*
    |-------------------------------------------------------------------------
    |
    |  生成hidden表单
    |
    |-------------------------------------------------------------------------
    */
    public function create_hidden_input($name ,$value){

        return  '<input type="hidden" name="'.$name.'" value="'.$value.'" >';
    }


    /*
    |-------------------------------------------------------------------------
    |
    |  把产品加入到购物车
    |
    |-------------------------------------------------------------------------
    */
    public function buy($goods_id ,$goods_number ,$goods_attr){

        $goods              = Goods::find($goods_id);

        if(empty($goods)){

            return false;
        }

        $query                 =  DB::table('cart')
                                    ->where('goods_id',$goods_id)
                                    ->where('user_id',Auth::user('user')->id)
                                    ->where('goods_attr',$goods_attr)
                                    ->first();
        

        //如果存在相同的记录 则更新商品数量即可
        if($query){

            $buy_number        = intval($query->goods_number)  + intval($goods_number);
            $kc                = intval($goods->goods_number);

            if($buy_number < $kc){

                DB::table('cart')
                    ->where('id',$query->id)
                    ->update(['goods_number'=>$buy_number]);
            }
        }
        //如果不存在记录 则需要全新插入记录
        else{

                $kc                     = intval($goods->goods_number);
                $goods_number           = intval($goods_number);
                $thumb                  = $this->get_goods_thumb($goods_id);

                $data                    = [
                                            'session_id'        => Session::getId(),
                                            'user_id'           => Auth::user()->id,
                                            'goods_id'          =>$goods_id,
                                            'goods_name'        =>$goods->goods_name,
                                            'goods_sn'          =>$goods->goods_sn,
                                            'market_price'      =>$goods->market_price,
                                            'shop_price'        =>$goods->shop_price,
                                            'goods_number'      =>$goods_number,
                                            'goods_attr'        =>$goods_attr,
                                            'thumb'             =>$thumb,

           ];

            if($goods_number < $kc){

                DB::table('cart')->insert($data);
            }

        }
    }


    /*
    |-------------------------------------------------------------------------
    |
    |  获取购物车中商品总数量
    |
    |-------------------------------------------------------------------------
    */
    public function get_cart_goods_number(){

        $res            = DB::table('cart')
                            ->where('user_id',Auth::user('user')->id)
                            ->sum('goods_number');
        return $res;
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 输出json格式的数据
    |
    |-------------------------------------------------------------------------------
    */
    public function toJSON($arr){

        echo json_encode($arr, JSON_UNESCAPED_UNICODE);
        exit;
    }




    /*
    |-------------------------------------------------------------------------
    |
    |  选中购物车中的单个商品
    |  type     = single
    |  code     = checked
    |  id       = id
    |
    |-------------------------------------------------------------------------
    */
    public function cart_mobile_single_checked($info){

        $id                     = intval($info->id);
        $cart                   = Cart::find($id);
        $value                  = intval($info->value);

        if(empty($cart)){

            return false;
        }

        $checked_value          = $cart->is_checked == 1? 0:1;

        $cart->is_checked       = $checked_value;
        $cart->save();

        $data                   = [
                                    
                                    'list'          => $this->get_mobile_cart_list_string($value),
                                    'number'        => Cart::number(),
        ];

        return $this->toJSON($data);

    }


    /*
    |-------------------------------------------------------------------------
    |
    |  商品数量 +1
    |
    |-------------------------------------------------------------------------
    */
    public function cart_mobile_single_add($info){

        $id                     = intval($info->id);
        $cart                   = Cart::find($id);
        $value                  = intval($info->value);

        if(empty($cart)){

            return false;
        }

        //执行购物车中记录+1 操作
        $cart->add();

        $data   = [
                                    
                    'list' => $this->get_mobile_cart_list_string($value),
                    'number'        => Cart::number(),
        ];

        return $this->toJSON($data);
    }


    /*
    |-------------------------------------------------------------------------
    |
    |  商品数量 -1
    |
    |-------------------------------------------------------------------------
    */
    public function cart_mobile_single_sub($info){

        $id                     = intval($info->id);
        $cart                   = Cart::find($id);
        $value                  = intval($info->value);

        if(empty($cart)){

            return false;
        }

        if($cart->goods_number <= 1){

            $data  = ['tag'=>'sub_error'];
            return $this->toJSON($data);

        }


        $cart->sub();

        $data   = [
                                    
                    'list' => $this->get_mobile_cart_list_string($value),
                    'number'        => Cart::number(),
        ];

        return $this->toJSON($data);
    }

    /*
    |-------------------------------------------------------------------------
    |
    |  删除购物车中单条记录
    |
    |-------------------------------------------------------------------------
    */
    public function cart_mobile_single_delete($info){

        $id                     = intval($info->id);
        $cart                   = Cart::find($id);
        $value                  = intval($info->value);
        if(empty($cart)){

            return false;
        }

        //删除这条记录
        $cart->delete();

        $data   = [
                                    
                    'list' => $this->get_mobile_cart_list_string($value),
                    'number'        => Cart::number(),
        ];

        return $this->toJSON($data);
    }


    /*
    |-------------------------------------------------------------------------
    |
    |  全部操作  选中或取消所有当前登录用户的购物车项
    |
    |-------------------------------------------------------------------------
    */
    public function cart_mobile_all_checked($info){

         $value                     = intval($info->value);

         foreach(Cart::cart() as $cart){

                $cart->is_checked   = $value;
                $cart->save();
         }

         $data   = [
                                    
                    'list'  => $this->get_mobile_cart_list_string($value),
                    'number'        => Cart::number(),
         ];

        return $this->toJSON($data);


    }

    /*
    |-------------------------------------------------------------------------
    |
    |  全部操作  清空购物车
    |
    |-------------------------------------------------------------------------
    */
    public function cart_mobile_all_delete($info){

         $value                     = intval($info->value);

         foreach(Cart::cart() as $cart){

               $cart->delete();
         }

         $data   = [
                                    
                    'list'  => $this->get_mobile_cart_list_string($value),
                    'number'        => Cart::number(),
         ];

        return $this->toJSON($data);


    }

    /*
    |-------------------------------------------------------------------------
    |
    |  批量操作 删除选中的购物车选项
    |
    |-------------------------------------------------------------------------
    */
    public function cart_mobile_batch_delete($info){

        $value                  = intval($info->value);
        $ids                    = $info->ids;

        foreach($ids as $id){

            $cart               = Cart::find($id);
            $cart->delete();
        }


        $data   = [
                                    
                    'list'  => $this->get_mobile_cart_list_string($value),
                    'number'        => Cart::number(),
         ];

        return $this->toJSON($data);
    }


    /*
    |-------------------------------------------------------------------------
    |
    |  获取购物车中记录字符串
    |
    |-------------------------------------------------------------------------
    */
    public function get_mobile_cart_list_string($value){

        $rows                = Cart::cart();

        $checked_all_tag     = '';
        if($value == 1){

            $checked_all_tag = ' checked="checked" ';

        }

        $str                 = '<tr>'
                             .'<th style="width:100px;">'
                             .'<input type="checkbox" name="all_select" '.$checked_all_tag.' id="all_select">'
                             .'<label for="all_select">选择</label>'
                             .'</th>'
                             .'<th>商品信息</th>'
                             .'<th>操作</th>'
                             .'</tr>';

        foreach($rows as $item){

            $checked_tag    = '';
            if($item->is_checked == 1){

                $checked_tag = ' checked="checked" ';
            }

            $str    .= '<tr>'
                      .'<td>'
                      .'<input type="checkbox"  name="ids[]" '
                      .$checked_tag
                      .' value="'.$item->id.'" ' 
                      .'class="cart-checkbox" '  
                      .' id="goods_id'.$item->id.'">'
                      .'<label for="goods_id'.$item->id.'"></label>'
                      .'</td>'
                      .'<td>';

            if($item->goods->thumb()){

                $str  .= '<p><a href="'
                      .$item->goods->url()
                      .'"><img src="'.$item->goods->thumb().'" class="responsive-img cart-thumb"></a></p>';
            }
                    
            $str      .= '<p>'.$item->goods_name.'</p>'
                        .'<p><small>'.$item->goods_attr.'</small></p>'
                        .'<p class="red-text">'.$item->shop_price.'</p>'
                        .'<p>'
                        .'<div class="number-div" data-id="'.$item->id.'" data-goods_number="'.$item->goods_number.'">'
                        .'<i class="material-icons left cart-add-btn">add</i>'
                        .'<i class="material-icons right cart-sub-btn">remove</i>'
                        .'<span class="goods_number_btn'.$item->id.'">'.$item->goods_number.'</span>'
                        .'</div>'
                        .'</p>'
                        .'</td>'
                        .'<td>'
                        .'<span class="cart-delete-btn" data-id="'.$item->id.'">'
                        .'<i class="material-icons red-text">remove_circle</i>'
                        .'</span>'
                        .'</td>'
                        .'</tr>';
        }


        //最后加上商品的数量和购物车中总金额
        $str              .= '<tr>'
                            .'<td>'
                            .'<p><i class="material-icons red-text" id="batch-delete-btn">remove_circle</i></p>'
                            .'</td>'
                            .'<td colspan="2">'
                            .'选中数量:<span class="red-text" id="cart-number-btn">'. Cart::checked_number() .'</span>'
                            .'总计:<span class="red-text" id="cart-amount-btn">'. Cart::amount() .'</span>'
                            .'</td>'
                            .'</tr>';

        return $str;
    }


}