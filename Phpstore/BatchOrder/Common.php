<?php namespace Phpstore\BatchOrder;

use Validator;
use App\Models\Goods;
use App\Models\Order;
use App\Models\Shipping;
use App\Models\Payment;
use App\Models\OrderGoods;
use Auth;

class Common{

    protected $arr;



    /*
    |-------------------------------------------------------------------------
    |
    | 批量下单相关操作
    | 
    |
    |-------------------------------------------------------------------------
    */
    function __construct(){



    }


    /*
    |-------------------------------------------------------------------------
    |
    | 每个订单之间 以1个或者多个#号来间隔开来
    |
    |-------------------------------------------------------------------------
    */
    public function get_order_array_from_string($str){

    	//去掉首尾的空格
    	$str 			= trim($str);
    	//以#号分割成数组
    	$arr 			= preg_split("/[\#]+/", $str);

    	return $arr;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 把单个订单中的 多个商品和地址信息分离出来形成新的数组
    | $num  --- 添加订单的序列号
    | $str  --- 订单中 商品+地址信息字符串
    |
    |-------------------------------------------------------------------------------
    */
    public function get_goods_and_address($num,$str){
        
        //去掉字符串中首尾的空格
        $str                            = trim($str);
        //以行来分割字符串为数组
        //$data 以字符串数组的形式存储了单个订单中的 所有商品信息 和地址信息
        $data                           = preg_split('/\n|\r\n?/', $str);
        //计算数组的大小
        $len                            = count($data);

        //如果只有一行数据 也就是没有地址信息或者只有地址信息 无商品信息
        if($len <= 1){
        	$temp_num 					= intval($num) + 1;
        	$info 						= '第'.$temp_num.'条订单数据错误！至少需要一条商品信息和地址信息';
        	return ['tag'=>'error','info'=>$info];
        }
        $goods                          = [];
        $address                        = [];

        foreach($data as $key=>$value){

            $arr                    = preg_split("/[\s,]+/", $value);
            //如果分割出来的格式不对 提示错误信息
            //以空格分离出来的数组 至少得有2个元素 商品名称+商品属性
            if(count($arr) < 2){

                $temp_num 					= intval($num) + 1;
        		$info 						= '第'.$temp_num.'条订单数据错误！商品或者地址信息错误';
        		return ['tag'=>'error','info'=>$info];
            }
            
            //如果是最后一行数据 则是地址信息
            if($key == $len - 1){
                //逗号或者空格分割地址信息 最后一行必须是地址
                $address['consignee']   = $arr[0];

                //检测手机号是否是11位
                $rules 					= ['phone'=>'required|digits:11'];
                $rules_data 			= ['phone'=>$arr[1]];

                $validator 				= Validator::make($rules_data,$rules);
                if($validator->fails()){

                	$temp_num 			= intval($num) + 1;
        			$info 				= '第'.$temp_num.'条订单数据错误！地址信息错误：手机号不为11位数字';
        			return ['tag'=>'error','info'=>$info];
                }

                $address['phone']       = $arr[1];
                $address['address']     = $arr[2];
            }
            //除了最后一行 其他行都是商品信息
            else{

            	//如果商品数量省略 则默认为1
                $goods_number           = 1;
                //如果有商品数量
                if(isset($arr[2]) && ($arr[2] !='')){

                    $goods_number       = $arr[2];
                }

                //根据给定的商品名称 搜索商品名称类似的商品列表
                $temp_goods 			= Goods::searchByName($arr[0]);
                //商品不存在 则提示错误信息
                if(!count($temp_goods)){

                	$temp_num 			= intval($num) + 1;
        			$info 				= '第'.$temp_num.'条订单数据错误！商品信息错误 名称为：'.$arr[0].' 的商品不存在';
        			return ['tag'=>'error','info'=>$info];
                }

                //逗号或者空格来分割商品信息
                $goods[]            = [
                                            'goods'         => Goods::searchByName($arr[0]),
                                            'goods_attr'    => $arr[1],
                                            'goods_number'  => $goods_number,
                                    
                ];

                //对商品进一步拆分 如果属性是 200/400/500 拆分成 200，400，500 三个商品
                $goods_list         = Goods::createListByAttr($goods);
            }
        }


        return ['tag'=>'success','goods'=>$goods_list,'address'=>$address ];

    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 生成单个订单信息
    |
    |-------------------------------------------------------------------------------
    */
    public function  create_order($key){

        //获取商品信息
         $goods_ids_name     = 'goods_ids'.$key;
         $goods_attrs_name   = 'goods_attrs'.$key;
         $goods_numbers_name = 'goods_numbers'.$key;

         $goods_ids          = request()->$goods_ids_name;
         $goods_attrs        = request()->$goods_attrs_name;
         $goods_numbers      = request()->$goods_numbers_name;

         //获取地址信息
         $consignee_name     = 'consignee'.$key;
         $phone_name         = 'phone'.$key;
         $address_name       = 'address'.$key;

         $consignee          = request()->$consignee_name;
         $phone              = request()->$phone_name;
         $address            = request()->$address_name;

         //如果商品不存在
         if(empty($goods_ids)){

            return false;
         }

         //商品总价格
         $goods_amount       = $this->goods_amount($goods_ids,$goods_numbers);
         $order_amount       = $goods_amount + Shipping::def()->shipping_fee;

         
         $data               = [
                                'order_sn'          => Order::order_sn(),             //订单编号
                                'user_id'           => Auth::user('user')->id,        //下单用户
                                'order_status'      => 0,                             //订单状态
                                'shipping_status'   => 0,                             //物流状态
                                'pay_status'        => 0,                             //支付状态
                                'consignee'         => $consignee,                    //收货人姓名
                                'country'           => 1,                             //国家
                                'address'           => $address,                      //地址
                                'phone'             => $phone,                        //手机
                                'email'             => Auth::user('user')->email,     //电子邮件
                                'shipping_id'       => Shipping::def()->id,           //配送方式编号
                                'shipping_name'     => Shipping::def()->shipping_name,
                                'pay_id'            => Payment::def()->id,            //支付编号
                                'pay_name'          => Payment::def()->pay_name,      //支付名称
                                'goods_amount'      => $goods_amount,                 //商品总金额
                                'shipping_fee'      => Shipping::def()->fee, //运费
                                'order_amount'      => $order_amount,                 //订单总金额
                                'add_time'          => time(),                        //订单生成时间
                                'ip'                => request()->getClientIP(),      //下单ip地址
                                'order_note'        =>'',                             //订单注释
                                'order_from'        =>'批量下单',                       //订单来源

        ];

        //订单创建成功
        if($order = Order::create($data)){

            //写入订单产品
            foreach($goods_ids as $key=>$goods_id){
                $model      = Goods::find($goods_id);
                $arr        = [

                                    'order_id'      =>$order->id,               //订单编号
                                    'goods_id'      =>$goods_id,                //商品编号
                                    'goods_name'    =>$model->goods_name,       //商品名称
                                    'goods_sn'      =>$model->goods_sn,         //商品货号
                                    'goods_number'  =>$goods_numbers[$key],     //商品库存
                                    'market_price'  =>$model->market_price,     //市场价格
                                    'shop_price'    =>$model->shop_price,       //店铺价格
                                    'goods_attr'    =>$goods_attrs[$key],       //属性

                ];

                //创建订单产品表记录
                OrderGoods::create($arr);
            }

            return $order;
        }

        return false;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 检测购买商品数量 是否超越了总库存
    |
    |-------------------------------------------------------------------------------
    */
    public function  check_goods_number($key){

        //获取商品信息
         $goods_ids_name     = 'goods_ids'.$key;
         $goods_attrs_name   = 'goods_attrs'.$key;
         $goods_numbers_name = 'goods_numbers'.$key;

         $goods_ids          = request()->$goods_ids_name;
         $goods_attrs        = request()->$goods_attrs_name;
         $goods_numbers      = request()->$goods_numbers_name;

         foreach($goods_ids as $item=>$goods_id){

              $goods                    = Goods::find($goods_id);
              $goods_number             = intval($goods_numbers[$item]);

              if($goods_number >= $goods->goods_number){

                return [
                            'tag'       =>'error',
                            'info'      =>'第'.($key+1).'条订单中 第'.($item+1).'个商品购买数量超过库存',
                        ];
              }
         }

         return ['tag'=>'success'];
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 获取商品的总价格
    |
    |-------------------------------------------------------------------------------
    */
    public function goods_amount($goods_ids,$goods_numbers){

        $amount                     = 0;

        foreach($goods_ids as $key=>$goods_id){

            $model                  = Goods::find($goods_id);
            $goods_number           = intval($goods_numbers[$key]);
            $amount                 += $model->shop_price * $goods_number;  
        }

        return $amount;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 根据订单数组 生成参数
    |
    |-------------------------------------------------------------------------------
    */
    public function create_order_parameter($order){
        
        $arr            = [];
        foreach($order as $value){

            $arr[]      = $value->id;
        }

        $str            ='?order_id='.serialize($arr);
        return $str;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 根据get递交的订单数组 生成订单信息
    |
    |-------------------------------------------------------------------------------
    */
    public function get_order_list($ids){

        $ids            = unserialize($ids);
        $arr            = [];
        foreach($ids as $id){

            $arr[]      = Order::find($id); 
        }

        return $arr;
    }




}