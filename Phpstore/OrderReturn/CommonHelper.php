<?php namespace Phpstore\OrderReturn;

use Phpstore\Grid\TableData;
use Phpstore\Grid\Grid;
use Phpstore\Grid\Page;
use Phpstore\Grid\Common;
use Phpstore\Base\Goodslib;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Goods;
use App\Models\Attribute;
use App\Models\GoodsAttr;
use App\Models\Article;
use App\Models\OrderReturn;
use App\Models\Order;
use DB;
use Auth;
use Request;

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

		//定义退货单的常用链接
        $this->list_url             = 'admin/return';
        $this->edit_url             = 'admin/return/edit';
        $this->add_url              = 'admin/return/create';
        $this->update_url           = 'admin/return/update';
        $this->del_url              = 'admin/return/delete/';
        $this->batch_url            = 'admin/return/batch';
        $this->preview_url          = '';
        $this->ajax_url             = 'admin/return/grid';
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
        $tableData->put('table','order_return');
        $tableData->put('sort_name','id');
        $tableData->put('sort_value','desc');

        //设置等于搜索数组
        //$tableData->addField('brand_id','');

        //设置搜索关键字
        $tableData->keywords('order_id','');

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
        $tableData->addCol('order_id','order_sn','订单号','');
        $tableData->addCol('username','username','用户名称','');
        $tableData->addCol('bank_name','bank_name','银行名称','');
        $tableData->addCol('bank_account','bank_account','银行账户','');
        $tableData->addCol('return_amount','return_amount','退款金额','');
        $tableData->addCol('admin','admin','操作管理员','');
        $tableData->addCol('ip','ip','ip地址','');
        $tableData->addCol('type','type','退货类型','');
        $tableData->addCol('return_status','return_status_str','退货状态','');
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

        foreach($data as $key=>$value){

           $model                                  = OrderReturn::find($value['id']);
           $data[$key]['add_time_str']             = $model->time();
           $data[$key]['return_status_str']        = $model->status();
           $data[$key]['order_sn']                 = ($model->order)? $model->order->order_sn : '';
            //操作链接
            $data[$key]['edit_url']                 = Common::get_resource_edit_url('admin/return',$value['id']);
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
        $tableData->put('table','order_return');
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
                        'name'          => '订单号',
                        'value'         => '',
                        'id'            => 'express_sn',
                    ],

                    [
                        'type'          => 'button',
                        'name'          => '搜索',
                        'id'            => 'search-btn',
						'back_url'		=> url($this->list_url),
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
                                    ['field'=>'order_id','value'=>'']
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
                        'type'          => 'select',
                        'field'         => 'order_id',
                        'name'          => '订单号',
                        'option_list'   => $this->get_option_list(),
                        'selected_name' => '请选择订单号',
                        'selected_value'=> 0,
                        'id'            => 'order_id',
                    ],
                    [
                        'type'          => 'text',
                        'field'         => 'username',
                        'name'          => '退货人',
                        'value'         => '',
                        'id'            => 'username',
                    ],
                    [
                        'type'          => 'select',
                        'field'         => 'type',
                        'name'          => '退货类型',
                        'option_list'   => $this->get_type_option_list(),
                        'selected_name' => '请选择退货类型',
                        'selected_value'=> 0,
                        'id'            => 'type',
                    ],

                    [
                        'type'          => 'textarea',
                        'field'         => 'return_note',
                        'name'          => '退货说明',
                        'value'         => '',
                        'id'            => 'return_note',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'bank_name',
                        'name'          => '银行名称',
                        'value'         => '',
                        'id'            => 'bank_name',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'bank_account',
                        'name'          => '银行账户',
                        'value'         => '',
                        'id'            => 'bank_account',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'return_amount',
                        'name'          => '退货金额',
                        'value'         => '',
                        'id'            => 'return_amount',
                    ],

                    [
                        'type'          => 'select',
                        'field'         => 'return_status',
                        'name'          => '退货状态',
                        'option_list'   => $this->get_return_status_option_list(),
                        'selected_name' => '请选择退货状态',
                        'selected_value'=> 0,
                        'id'            => 'return_status',
                    ],

                    [
                        'type'          => 'insert',
                        'field'         => 'admin',
                        'value'         => Auth::user('admin')->username,
                    ],

                    [
                        'type'          => 'insert',
                        'field'         => 'add_time',
                        'value'         => time(),
                    ],
                    [
                        'type'          => 'insert',
                        'field'         => 'ip',
                        'value'         => Request::getClientIp(),
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
                        'type'          => 'select',
                        'field'         => 'order_id',
                        'name'          => '订单号',
                        'option_list'   => $this->get_option_list(),
                        'selected_name' => ($model->order)?$model->order->order_sn:'',
                        'selected_value'=> $model->order_id,
                        'id'            => 'order_id',
                    ],
                    [
                        'type'          => 'text',
                        'field'         => 'username',
                        'name'          => '退货人',
                        'value'         => $model->username,
                        'id'            => 'username',
                    ],
                    [
                        'type'          => 'select',
                        'field'         => 'type',
                        'name'          => '退货类型',
                        'option_list'   => $this->get_type_option_list(),
                        'selected_name' => $model->type,
                        'selected_value'=> $model->type,
                        'id'            => 'type',
                    ],

                    [
                        'type'          => 'textarea',
                        'field'         => 'return_note',
                        'name'          => '退货说明',
                        'value'         => $model->return_note,
                        'id'            => 'return_note',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'bank_name',
                        'name'          => '银行名称',
                        'value'         => $model->bank_name,
                        'id'            => 'bank_name',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'bank_account',
                        'name'          => '银行账户',
                        'value'         => $model->bank_account,
                        'id'            => 'bank_account',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'return_amount',
                        'name'          => '退货金额',
                        'value'         => $model->return_amount,
                        'id'            => 'return_amount',
                    ],

                    [
                        'type'          => 'select',
                        'field'         => 'return_status',
                        'name'          => '退货状态',
                        'option_list'   => $this->get_return_status_option_list(),
                        'selected_name' => $this->get_return_status($model->return_status),
                        'selected_value'=> $model->return_status,
                        'id'            => 'return_status',
                    ],

                    [
                        'type'          => 'insert',
                        'field'         => 'admin',
                        'value'         => Auth::user('admin')->username,
                    ],

                    [
                        'type'          => 'insert',
                        'field'         => 'add_time',
                        'value'         => time(),
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'ip',
                        'name'          => '申请ip',
                        'value'         => $model->ip,
                        'id'            => 'ip',
                    ],
                    

                    [
                        'type'          => 'hidden',
                        'field'         => 'id',
                        'name'          => 'id',
                        'value'         => $model->id,
                        'id'            => 'method',
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

        $res                        = DB::table('order_info')
                                        ->where('return_status',0)
                                        ->get();

        $str                        = '';

        foreach($res as $item){

            $str .= '<option value="'.$item->id.'">'.$item->order_sn.'</option>';
        }

        return $str;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  获取退货的类型
    |
    |-------------------------------------------------------------------------------
    */
    public function get_type_option_list(){

        $row                        = ['全部退货','部分退货','换货'];

        $str                        = '';

        foreach($row as $item){

            $str .= '<option value="'.$item.'">'.$item.'</option>';
        }

        return $str;
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  获取退货状态
    |
    |-------------------------------------------------------------------------------
    */
    public function get_return_status_option_list(){

        $row                        = ['禁止退货','退货申请中','退货已批准','退货已完成'];

        $str                        = '';

        foreach($row as $key=>$value){

            $str .= '<option value="'.$key.'">'.$value.'</option>';
        }

        return $str;
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  获取退货状态
    |
    |-------------------------------------------------------------------------------
    */
    public function get_return_status($tag){

        $row                        = ['禁止退货','退货申请中','退货已批准','退货已完成'];
        $tag                        = intval($tag);

        if(in_array($tag,[0,1,2,3])){

            return $row[$tag];
        }

        return $row[0];

    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  同步退货状态到订单数据表中
    |
    |-------------------------------------------------------------------------------
    */
    public function return_status_sync($return_id , $order_id){

        $order              = Order::find($order_id);
        $order_return       = OrderReturn::find($return_id);

        if(empty($order)||empty($order_return)){

            return false;
        }

        $order->return_status  = $order_return->return_status;
        $order->save();
    }
}
