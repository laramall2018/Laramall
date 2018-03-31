<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Phpstore\Repository\OrderRepository;
use LaraStore\Presenters\OrderPresenter;
class Order extends Model{

	use OrderRepository;
	protected $table 		= 'order_info';
	protected $fillable  	= [
								'order_sn',				//订单编号
								'user_id',				//下单用户
								'order_status',			//订单状态
								'shipping_status',		//物流状态
								'pay_status',			//支付状态
								'consignee',			//收货人姓名
								'country',				//国家
								'province',				//省会
								'city',					//城市
								'district',				//区域
								'address',				//地址
								'phone',				//手机
								'email',				//电子邮件
								'shipping_id',			//配送方式编号
								'shipping_name',		//配送名称
								'pay_id',				//支付编号
								'pay_name',			    //支付名称
								'goods_amount',			//商品总金额
								'shipping_fee',			//运费
								'order_amount',			//订单总金额
								'add_time',				//订单生成时间
								'ip',					//下单ip地址
								'order_note',			//订单注释
                                'card_id',              //礼品卡编号
								'order_from',			//订单来源

	];
    protected $appends      = ['createTime','status','url'];




    /*
    |-------------------------------------------------------------------------------
    |
    |   订单和订单产品为一对多的关系
    |
    |-------------------------------------------------------------------------------
    */
    public function order_goods(){

    	return $this->hasMany(OrderGoods::class,'order_id','id');
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |   订单和退货单为一对一关联模型
    |
    |-------------------------------------------------------------------------------
    */
    public function order_return(){

        return $this->hasOne(OrderReturn::class,'order_id','id');
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |   一对多关联 一个用户 可以拥有多个订单
    |
    |-------------------------------------------------------------------------------
    */
    public function user(){

    	return $this->belongsTo('App\User','user_id','id');
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   订单和支付方式 为多对一的关系
    |
    |-------------------------------------------------------------------------------
    */
    public function payment(){

        return $this->belongsTo(Payment::class,'pay_id','id');
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |   一对一关联关系 订单和发票关系
    |
    |-------------------------------------------------------------------------------
    */
    public function fp(){

        return $this->hasOne(Fp::class,'order_id','id');
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |   一对一关联关系 订单和礼品卡的关系
    |
    |-------------------------------------------------------------------------------
    */
    public function card(){

        return $this->belongsTo(Card::class,'card_id','id');
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |   订单添加时间
    |
    |-------------------------------------------------------------------------------
    */
    public function time(){

    	return date('Y-m-d',$this->add_time);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   订单和商品为多对多关联
    |
    |-------------------------------------------------------------------------------
    */
    public function goods(){

        return $this->belongsToMany(Goods::class,'order_goods','order_id','goods_id')->groupBy('goods_id');
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   获取订单的状态
    |
    |-------------------------------------------------------------------------------
    */
    public function status(){

         $str                   = '';

         $order_status          = $this->order_status;
         $pay_status            = $this->pay_status;
         $shipping_status       = $this->shipping_status;
         $return_status         = $this->return_status;
         $cancel_status         = $this->cancel_status;

         //状态数组
         $order_status_arr      = ['未确认','已确认'];
         $pay_status_arr        = ['未支付','已支付'];
         $shipping_status_arr   = ['未发货','已发货'];


         if($cancel_status == 1){

             $str               = '订单已取消';
             return $str;
         }
         else{

             if($return_status == 1){


                    $str        = '退货申请中';
                    return $str;
             }
             elseif($return_status == 2){

                    $str        = '退货已批准';
                    return $str;
             }
             elseif($return_status == 3){

                    $str        = '退货完成';
                    return $str;
             }
             else{

                    //未发生退货 也未取消订单
                    $str        =   $order_status_arr[$order_status]
                                   .$pay_status_arr[$pay_status]
                                   .$shipping_status_arr[$shipping_status];
             }
         }

         return $str;
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |    判断是否显示 支付按钮
    |
    |-------------------------------------------------------------------------------
    */
    public function is_pay(){

        if($this->cancel_status == 0){

            if($this->pay_status == 0){

                return true;
            }
        }

        return false;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |    判断是否可以退货
    |
    |-------------------------------------------------------------------------------
    */
    public function is_return(){

        if($this->pay_status == 1 && $this->return_status == 0){

            return true;
        }

        return false;
    }

    

    /*
    |-------------------------------------------------------------------------------
    |
    |    获取收货人地址信息
    |
    |-------------------------------------------------------------------------------
    */
    public function address(){

        $str =  Region::name($this->country) 
               . Region::name($this->province) 
               . Region::name($this->city) 
               . Region::name($this->district)
               . $this->address;

        return $str;

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   订单总金额
    |
    |-------------------------------------------------------------------------------
    */
    public function amount(){

        return $this->goods_amount + $this->shipping_fee;
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |   获取多个订单的总商品金额
    |
    |-------------------------------------------------------------------------------
    */
    public static function amounts($ids){

        $amount             = 0;

        if(count($ids) == 0){

            return 0;
        }

        foreach($ids as $id){

            $model          = Order::find($id);
            $amount         += $model->goods_amount;
        }

        return $amount;

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   获取配送费用
    |
    |-------------------------------------------------------------------------------
    */
    public static function fees($ids){

        $fees               = 0;

        if(count($ids)){

            return 0;
        }

        foreach($ids as $id){

            $model         = Order::find($id);
            $shipping_fee  = $model->shipping_fee;
            $fees          = $fees + floatval($shipping_fee);
        }

        return $fees;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   获取订单集合总费用
    |
    |-------------------------------------------------------------------------------
    */
    public static function totals($ids){

        $total              = 0;

        if(count($ids) == 0 ){

            return $total;
        }

        foreach($ids as $id){

            $model         = Order::find($id);

            $total        += $model->amount();
        }

        return $total;
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |   设置子订单
    |
    |-------------------------------------------------------------------------------
    */
    public function children($ids){

        if(count($ids) == 0){

            return false;
        }

        foreach($ids as $id){

            $child                  = Order::find($id);
            $child->parent_id       = $this->id;
            $child->save();
        }
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |   把子订单中的订单产品 写入父订单结点中
    |
    |-------------------------------------------------------------------------------
    */
    public function children_goods($ids){

        if(count($ids) == 0){

            return false;
        }

        foreach($ids as $id){

            $child                  = Order::find($id);
            
            foreach($child->order_goods()->get() as $item){

                //创建父订单的订单产品
                OrderGoods::create([

                                    'order_id'=>$this->id,               //订单编号
                                    'goods_id'=>$item->goods_id,         //商品编号
                                    'goods_name'=>$item->goods_name,     //商品名称
                                    'goods_sn'=>$item->goods_sn,         //商品货号
                                    'goods_number'=>$item->goods_number, //商品库存
                                    'market_price'=>$item->market_price, //市场价格
                                    'shop_price'=>$item->shop_price,     //店铺价格
                                    'goods_attr'=>$item->goods_attr,     //属性
            ]);
          }
        }
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   修改子订单的支付状态
    |
    |-------------------------------------------------------------------------------
    */
    public function childPaySuccess(){

        $childrens          = Order::where('parent_id',$this->id)->get();

        if(count($childrens) == 0){

            return false;
        }

        foreach($childrens as $item){

            $item->pay_status   = 1;
            $item->save();
        }
        
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   presenter
    |
    |-------------------------------------------------------------------------------
    */
    public function presenter(){

        return new OrderPresenter($this);
        
    }

}