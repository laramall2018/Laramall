<?php namespace Phpstore\Express;

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
use App\Models\Express;
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
        $this->list_url             = 'admin/express';
        $this->edit_url             = 'admin/express/edit';
        $this->add_url              = 'admin/express/create';
        $this->update_url           = 'admin/express/update';
        $this->del_url              = 'admin/express/delete/';
        $this->batch_url            = 'admin/express/batch';
        $this->preview_url          = '';
        $this->ajax_url             = 'admin/express/grid';
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
        $tableData->put('table','order_express');
        $tableData->put('sort_name','id');
        $tableData->put('sort_value','desc');

        //设置等于搜索数组
        //$tableData->addField('brand_id','');

        //设置搜索关键字
        $tableData->keywords('order_sn','');

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
        $tableData->addCol('order_sn','order_sn','订单号','');
        $tableData->addCol('express_sn','express_sn','快递单号','');
        $tableData->addCol('address','address','收货地址','');
        $tableData->addCol('consignee','consignee','收货人','');
        $tableData->addCol('phone','phone','联系方式','');
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

           $data[$key]['add_time_str']             = date('Y-m-d H:i:s',$value['add_time']);
            //操作链接
            $data[$key]['edit_url']                 = Common::get_resource_edit_url('admin/express',$value['id']);
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
        $tableData->put('table','order_express');
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
                        'field'         => 'express_sn',
                        'name'          => '快递单号',
                        'value'         => '',
                        'id'            => 'express_sn',
                    ],

                    [
                        'type'          => 'button',
                        'name'          => '搜索',
                        'id'            => 'search-btn',
						'back_url'			=> url($this->list_url),
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
                                    ['field'=>'express_sn','value'=>'']
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
                        'field'         => 'order_sn',
                        'name'          => '订单号',
                        'option_list'   => $this->get_option_list(),
                        'selected_name' => '请选择订单号',
                        'selected_value'=> 0,
                        'id'            => 'order_sn',
                    ],
                    [
                        'type'          => 'text',
                        'field'         => 'consignee',
                        'name'          => '收货人',
                        'value'         => '',
                        'id'            => 'consignee',
                    ],
                    [
                        'type'          => 'select',
                        'field'         => 'express_name',
                        'name'          => '快递公司名称',
                        'option_list'   => $this->get_express_option_list(),
                        'selected_name' => '请选择快递公司名称',
                        'selected_value'=> 0,
                        'id'            => 'express_name',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'address',
                        'name'          => '地址',
                        'value'         => '',
                        'id'            => 'address',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'phone',
                        'name'          => '手机号码',
                        'value'         => '',
                        'id'            => 'phone',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'express_sn',
                        'name'          => '快递单号',
                        'value'         => '',
                        'id'            => 'express_sn',
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
                        'type'          => 'select',
                        'field'         => 'order_sn',
                        'name'          => '订单号',
                        'option_list'   => $this->get_option_list(),
                        'selected_name' => $model->order_sn,
                        'selected_value'=> $model->order_sn,
                        'id'            => 'order_sn',
                    ],
                    [
                        'type'          => 'text',
                        'field'         => 'consignee',
                        'name'          => '收货人',
                        'value'         => $model->consignee,
                        'id'            => 'consignee',
                    ],
                    [
                        'type'          => 'select',
                        'field'         => 'express_name',
                        'name'          => '快递公司名称',
                        'option_list'   => $this->get_express_option_list(),
                        'selected_name' => $model->express_name,
                        'selected_value'=> $model->express_name,
                        'id'            => 'express_name',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'address',
                        'name'          => '地址',
                        'value'         => $model->address,
                        'id'            => 'address',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'phone',
                        'name'          => '手机号码',
                        'value'         => $model->phone,
                        'id'            => 'phone',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'express_sn',
                        'name'          => '快递单号',
                        'value'         => $model->express_sn,
                        'id'            => 'express_sn',
                    ],

                    [
                        'type'          => 'insert',
                        'field'         => 'add_time',
                        'value'         => time(),
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
                                        ->where('cancel_status',0)
                                        ->where('shipping_status',0)
                                        ->get();

        $str                        = '';

        foreach($res as $item){

            $str .= '<option value="'.$item->order_sn.'">'.$item->order_sn.'</option>';
        }

        return $str;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  获取快递公司名称
    |
    |-------------------------------------------------------------------------------
    */
    public function get_express_option_list(){

        $res                        = DB::table('shipping')->get();

        $str                        = '';

        foreach($res as $item){

            $str .= '<option value="'.$item->shipping_name.'">'.$item->shipping_name.'</option>';
        }

        return $str;
    }

}
