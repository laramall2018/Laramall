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



/*
|-------------------------------------------------------------------------------
|
|   商品控制器里面的grid相应操作函数
|
|-------------------------------------------------------------------------------
|
|   tableDataInit  	    --------------- 初始化tableData实例 并赋值给grid实例
|   setTableDataCol		  --------------- 设置tabledata实例需要显示的数据库字段
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
class CommonHelper{

    protected $data;



    /*
    |----------------------------------------------------------------------------
    |
    |  构造函数
    |
    |----------------------------------------------------------------------------
    */
    function __construct(){

        //定义商品的常用操作链接
        $this->list_url             = 'admin/order';
        $this->edit_url             = 'admin/order/edit/';
        $this->add_url              = 'admin/order/create';
        $this->update_url           = 'admin/order/update';
        $this->del_url              = 'admin/order/delete/';
        $this->batch_url            = 'admin/order/batch';
        $this->ajax_url             = 'admin/order/grid';
    }

    /*
  |-------------------------------------------------------------------------------
  |
  |  初始化tableData 输出初始的商品列表dom元素
  |  设置 数据表   					table ---- goods
  |  设置排序方式  					orderBy('id','desc')
  |  设置等于搜索
  |
  |  brand_id  					品牌
  |  is_new    					新品
  |  is_best   					精品
  |  is_hot    					热卖
  |  is_on_sale 					上架
  |
  |  设置关键字搜索  				商品名称 goods_name
  |  where('goods_name','like',''.$goods_name.'')
  |
  |  设置whereIn操作
  |  whereIn('cat_id',[1,2,3,4,5])
  |  系统会根据以上条件拼接sql查询 把最终结果返回给grid类来处理
  |
  |-------------------------------------------------------------------------------
  */
    public function tableDataInit(){


        $tableData                  = new TableData();

        //设置参数
        $tableData->put('table','order_info');
        $tableData->put('sort_name','id');
        $tableData->put('sort_value','desc');

        //设置等于搜索数组
        $tableData->addField('order_type',0);

        //设置搜索关键字
        $tableData->keywords('order_sn','');
        $tableData->keywords('consignee','');
        $tableData->keywords('phone','');
        $tableData->keywords('address','');
        $tableData->keywords('shipping_name','');
        $tableData->keywords('pay_name','');


        //设置whereIn搜索
        //$tableData->whereIn('cat_id',[]);


        //设置数据表格每列显示的字段名称
        $tableData              = $this->setTableDataCol($tableData);

        //给page设置参数
        $current_page           = 1;
        $per_page               = 20;
        $total                  = intval($tableData->total());
        $last_page              = ceil($total / $per_page);
        $tableData->page('current_page',$current_page);
        $tableData->page('per_page',$per_page);
        $tableData->page('total',$total);
        $tableData->page('last_page',$last_page);

        //获取个性化后的数据
        $data                   = $this->getData($tableData->toArray());
        $tableData->put('data',$data);

        return $tableData;

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   设置数据表中需要显示的所有数据字段 并根据需求格式化数据内容
    |
    |-------------------------------------------------------------------------------
    */
    public function setTableDataCol(TableData $tableData){

        //设置数据表格每列显示的字段名称
        $tableData->addCol('id','id','编号','100px');
        $tableData->addCol('order_sn','order_sn','订单编号','');
        $tableData->addCol('address','address','收货地址','');
        $tableData->addCol('consignee','consignee','收货人姓名','');
        $tableData->addCol('phone','phone','联系人电话','');
        $tableData->addCol('user_id','username','会员账号','');
        $tableData->addCol('order_status','order_status_str','订单状态','');
        $tableData->addCol('shipping_status','shipping_status_str','配送状态','');
        $tableData->addCol('pay_status','pay_status_str','支付状态','');
        $tableData->addCol('add_time','add_time_str','添加时间','');

        return $tableData;

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  把获取的数据 再进一步格式化
    |
    |-------------------------------------------------------------------------------
    */
    public function getData($data){

        if(empty($data)){

            return '';
        }

        $user_common                                = new \Phpstore\Front\UserCommon();

        foreach($data as $key=>$value){

            $data[$key]['username']                 = Common::get_username($value['user_id']);
            $data[$key]['order_status_str']         = $user_common->get_order_status($value['id']); 
            $data[$key]['shipping_status_str']      = Common::get_order_status($value['shipping_status'],'shipping_status');
            $data[$key]['pay_status_str']           = Common::get_order_status($value['pay_status'],'pay_status');

            $data[$key]['add_time_str']             = date('Y-m-d H:i:s',$value['add_time']);
            //操作链接
            $data[$key]['edit_url']                 = Common::get_resource_edit_url('admin/order',$value['id']);
            $data[$key]['del_url']                  = Common::get_del_url($this->del_url,$value['id']);
            $data[$key]['preview_url']              = '';
        }

        return $data;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  根据返回的json格式的数据  格式化相关数据
    |
    |-------------------------------------------------------------------------------
    */
    public function getTableData($info){


        $tableData                  = new TableData();

        $sort_name                  = $info->sort_name;
        $sort_value                 = $info->sort_value;
        $current_page               = $info->page;
        $per_page                   = $info->per_page;

        $fieldRow                   = $info->fieldRow;
        $keywords                   = $info->keywords;
        $whereIn                    = $info->whereIn;


        //设置参数
        $tableData->put('table','order_info');
        $tableData->put('sort_name',$sort_name);
        $tableData->put('sort_value',$sort_value);

        //设置关键词
        if($keywords){

            foreach($keywords as $key=>$value){

                $tableData->keywords($key , $value);
            }
        }

        //设置fieldRow 等于搜索
        if($fieldRow){

            foreach($fieldRow as $key=>$value){

                $tableData->addField($key , $value);
            }
        }

        //设置whereIn搜索
        /*
if($whereIn){

     $in_field              = $whereIn->in_field;
     $in_value              = $whereIn->in_value;

     //这里为商品分类  获取该分类下所有子类
     $row                   = Common::get_child_row($in_value);

     $tableData->whereIn($in_field,$row);
}
        */

        //设置数据表格每列显示的字段名称
        $tableData              = $this->setTableDataCol($tableData);

        //设置分页参数信息
        $total                  = intval($tableData->total());
        $last_page              = ceil($total / $per_page);
        $tableData->page('current_page',$current_page);
        $tableData->page('per_page',$per_page);
        $tableData->page('total',$total);
        $tableData->page('last_page',$last_page);

        //获取个性化后的数据
        $data                   = $this->getData($tableData->toArray());
        $tableData->put('data',$data);

        return $tableData;
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 生成grid页面 搜索表单的配置数组
    |
    |-------------------------------------------------------------------------------
    */
    public function searchData(){

        return [

            [
                'type'          => 'select',
                'field'         => 'per_page',
                'name'          => '分页大小',
                'option_list'   => Common::get_per_page_option_list(),
                'selected_name' => '5个/页',
                'selected_value'=> 5,
                'id'            => 'per_page',
            ],

            [
                'type'          => 'text',
                'field'         => 'order_sn',
                'name'          => '订单编号',
                'value'         => '',
                'id'            => 'order_sn',
            ],
            [
                'type'          => 'text',
                'field'         => 'consignee',
                'name'          => '收货人姓名',
                'value'         => '',
                'id'            => 'consignee',
            ],
            [
                'type'          => 'text',
                'field'         => 'phone',
                'name'          => '联系电话',
                'value'         => '',
                'id'            => 'phone',
            ],
            [
                'type'          => 'text',
                'field'         => 'address',
                'name'          => '收货地址',
                'value'         => '',
                'id'            => 'address',
            ],
            [
                'type'          => 'text',
                'field'         => 'shipping_name',
                'name'          => '物流名称',
                'value'         => '',
                'id'            => 'shipping_name',
            ],

            [
                'type'          => 'text',
                'field'         => 'pay_name',
                'name'          => '支付名称',
                'value'         => '',
                'id'            => 'pay_name',
            ],

            [
                'type'          => 'hidden',
                'field'         => 'order_type',
                'value'         =>  0,
                'id'            => 'order_type'
            ],

            [
                'type'          => 'button',
                'name'          => '搜索',
                'id'            => 'search-btn',
                'back_url'		=> url('admin/order'),
            ],
        ];

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  把执行ajax的搜索参数 用json格式化后 传递给grid页面
    |
    |-------------------------------------------------------------------------------
    */
    public function searchInfo(){

        $row    = [

            'keywords'=>[
                            ['field'=>'order_sn','value'=>''],
                            ['field'=>'consignee','value'=>''],
                            ['field'=>'phone','value'=>''],
                            ['field'=>'address','value'=>''],
                            ['field'=>'shipping_name','value'=>''],
                            ['field'=>'pay_name','value'=>''],
                            ['field'=>'order_type','value'=>1],
            ],

            'fieldRow'=>[

            ],

            'whereIn'=>[ ],
        ];


        return  json_encode($row,JSON_UNESCAPED_UNICODE);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 返回系统表单字段的配置文件数组
    |
    |-------------------------------------------------------------------------------
    */
    public function FormData(){

        return [

            [
                'type'          => 'text',
                'field'         => 'title',
                'name'          => '新闻标题',
                'value'         => '',
                'id'            => 'title',
            ],

            [
                'type'          => 'select',
                'field'         => 'cat_id',
                'name'          => '新闻分类',
                'option_list'   => $this->get_option_list(),
                'selected_name' => '请选择分类',
                'selected_value'=> 0,
                'id'            => 'parent_id',
            ],

            [
                'type'          => 'radio',
                'field'         => 'is_show',
                'name'          => '是否显示',
                'radio_row'     => $this->get_radio(),
                'checked'       => 1,
                'id'            => 'is_show',
            ],

            [
                'type'          => 'ueditor',
                'field'         => 'content',
                'name'          => '新闻内容',
                'value'         => '',
                'id'            => 'editor',
            ],
            [
                'type'          => 'text',
                'field'         => 'keywords',
                'name'          => '关键词',
                'value'         => '',
                'id'            => 'keywords',
            ],
            [
                'type'          => 'text',
                'field'         => 'description',
                'name'          => '简单介绍',
                'value'         => '',
                'id'            => 'description',
            ],
            [
                'type'          => 'text',
                'field'         => 'author',
                'name'          => '新闻作者',
                'value'         => '',
                'id'            => 'author',
            ],
            [
                'type'          => 'text',
                'field'         => 'sort_order',
                'name'          => '排序',
                'value'         => '',
                'id'            => 'sort_order',
            ],

            [
                'type'          =>'file',
                'field'         =>'thumb',
                'name'          =>'新闻缩略图',
                'upload_img'    =>'',
                'file_info'     =>'',
                'id'            =>'thumb'
            ],

            [
                'type'          => 'insert',
                'field'         => 'add_time',
                'value'         => time(),
            ],


            [
                'type'          => 'submit',
                'value'         => '确认添加',
                'id'            => 'cat-submit',
                'back_url'      => url($this->list_url),
            ],
        ];

    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 返回系统表单字段的配置文件数组 编辑
    |
    |-------------------------------------------------------------------------------
    */
    public function EditData($model){

        return [

            [
                'type'          => 'text',
                'field'         => 'title',
                'name'          => '新闻标题',
                'value'         => $model->title,
                'id'            => 'title',
            ],

            [
                'type'          => 'select',
                'field'         => 'cat_id',
                'name'          => '新闻分类',
                'option_list'   => $this->get_option_list(),
                'selected_name' => $this->get_cat_name($model->cat_id),
                'selected_value'=> $model->cat_id,
                'id'            => 'parent_id',
            ],

            [
                'type'          => 'radio',
                'field'         => 'is_show',
                'name'          => '是否显示',
                'radio_row'     => $this->get_radio(),
                'checked'       => $model->is_show,
                'id'            => 'is_show',
            ],

            [
                'type'          => 'ueditor',
                'field'         => 'content',
                'name'          => '新闻内容',
                'value'         => $model->content,
                'id'            => 'editor',
            ],
            [
                'type'          => 'text',
                'field'         => 'keywords',
                'name'          => '关键词',
                'value'         => $model->keywords,
                'id'            => 'keywords',
            ],
            [
                'type'          => 'text',
                'field'         => 'description',
                'name'          => '简单介绍',
                'value'         => $model->description,
                'id'            => 'description',
            ],
            [
                'type'          => 'text',
                'field'         => 'author',
                'name'          => '新闻作者',
                'value'         => $model->author,
                'id'            => 'author',
            ],
            [
                'type'          => 'text',
                'field'         => 'sort_order',
                'name'          => '排序',
                'value'         => $model->sort_order,
                'id'            => 'sort_order',
            ],

            [
                'type'          =>'file',
                'field'         =>'thumb',
                'name'          =>'新闻缩略图',
                'upload_img'    =>$model->thumb,
                'file_info'     =>'',
                'id'            =>'thumb'
            ],

            [
                'type'          => 'insert',
                'field'         => 'add_time',
                'value'         => time(),
            ],
            [
                'type'          => 'hidden',
                'field'         => 'id',
                'value'         =>  $model->id,
                'id'            => 'id'
            ],

            [
                'type'          => 'hidden',
                'field'         => '_method',
                'name'          => '表单递交方法',
                'value'         => 'PUT',
                'id'            => 'method',
            ],


            [
                'type'          => 'submit',
                'value'         => '确认编辑',
                'id'            => 'cat-submit',
                'back_url'      => url($this->list_url),
            ],
        ];

    }



    /*
    |-------------------------------------------------------------------------------
    |
    |  获取系统下拉选项
    |
    |-------------------------------------------------------------------------------
    */
    public function get_option_list(){

        $article_cat_list           = ArticleCat::all();

        $str                        = '';

        foreach($article_cat_list as $item){

            $str .= '<option value="'.$item->id.'">'.$item->cat_name.'</option>';
        }

        return $str;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 返回系统的下拉菜单选项
    |
    |-------------------------------------------------------------------------------
    */
    public function get_radio(){

        return [

            ['name'=>'不显示','value'=>0],
            ['name'=>'显示','value'=>1],

        ];
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  获取分类名称
    |
    |-------------------------------------------------------------------------------
    */
    public function get_cat_name($cat_id){

        $cat        = ArticleCat::find($cat_id);

        if($cat){

            return $cat->cat_name;
        }

        return '';
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  获取所有会员下拉列表
    |
    |-------------------------------------------------------------------------------
    */
    public function get_user_list_option(){

            $res        = User::where('is_admin',0)->get();
            $str        = '';

            if(empty($res)){

                return $str;
            }

            foreach($res as $item){

                $str .= '<option value="'.$item->id.'">'.$item->username.'</option>';
            }

            return $str;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  把产品写入到订单产品表中
    |
    |-------------------------------------------------------------------------------
    */
    public function insert_order_goods($ids ,$order_id){

        $model          = Order::find($order_id);

        if(empty($model) ||empty($ids)){

            return false;
        }

        $sum           = 0;

        foreach($ids as $id){

            //如果商品存在 插入到订单商品表中
            if($goods = Goods::find($id)){

                    $data   = [
                                    'order_id'      =>$order_id,
                                    'goods_id'      =>$id,
                                    'goods_name'    =>$goods->goods_name,
                                    'goods_sn'      =>$goods->goods_sn,
                                    'goods_number'  =>1,
                                    'market_price'  =>$goods->market_price,
                                    'shop_price'    =>$goods->shop_price
                    ];

                    DB::table('order_goods')->insert($data);

                    $sum    += $goods->shop_price ;
            }
        }

        //写入商品总金额到订单
        $shipping_fee           = $model->shipping_fee;
        $model->goods_amount    = $sum;
        $model->order_amount    = $sum + $shipping_fee;
        $model->save();
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
    |  获取用户名
    |
    |-------------------------------------------------------------------------
    */
    public function get_user_name($user_id){

            $user           = User::find($user_id);

            if($user){

                return $user->username;
            }

            return '匿名';
    }


    /*
    |-------------------------------------------------------------------------
    |
    |  获取配送方式名称
    |
    |-------------------------------------------------------------------------
    */
    public function get_pay_name($pay_id){

        $model          = Payment::find($pay_id);

        if($model){

            return $model->pay_name;
        }

        return '';
    }

    /*
    |-------------------------------------------------------------------------
    |
    |  获取配送方式
    |
    |-------------------------------------------------------------------------
    */
    public function get_shipping_name($shipping_id){

        $model          = Shipping::find($shipping_id);

        if($model){

             return $model->shipping_name;
        }

        return '';
    }

    /*
    |-------------------------------------------------------------------------
    |
    |  获取配送方式的价格
    |
    |-------------------------------------------------------------------------
    */
    public function get_shipping_fee($shipping_id){

        $model          = Shipping::find($shipping_id);

        if($model){

            return $model->fee;
        }

        return 0;
    }


    public function get_region_name($region_id){

        $region         = Region::find($region_id);

        if($region){

            return $region->region_name;
        }

        return '';


    }


    /*
    |-------------------------------------------------------------------------
    |
    |  获取订单的详细配送地址信息
    |
    |-------------------------------------------------------------------------
    */
    public function get_order_address($order_id){

        $order          = Order::find($order_id);

        if(empty($order)){

            return '';
        }

        $country        = $this->get_region_name($order->country);
        $province       = $this->get_region_name($order->province);
        $city           = $this->get_region_name($order->city);
        $district       = $this->get_region_name($order->district);
        $address        = $order->address;

        return $country.$province.$city.$district.$address;
    }


    /*
    |-------------------------------------------------------------------------
    |
    |  获取订单的配送状态
    |
    |-------------------------------------------------------------------------
    */
    public function get_shipping_status($order_id){

        $order          = Order::find($order_id);

        if(empty($order)){

            return  '';
        }

        if($order->shipping_status == 1){

            return '已经发货';
        }

        return '未发货';

    }


    

}
