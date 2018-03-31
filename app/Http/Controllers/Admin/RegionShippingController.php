<?php

namespace App\Http\Controllers\Admin;


use App\Models\Region;
use App\Models\RegionShipping;
use App\Models\Shipping;
use DB;
use File;
use HTML;
use Input;
use Phpstore\Grid\Common;
use Request;

class RegionShippingController extends SuperController
{
    public $ctl;
    public $page;
    public $tag;
    public $view;
    public $layout;
    public $form;
    public $crud;
    public $row;
    public $form_to_model;
    public $list_name;
    public $add_name;
    public $edit_name;
    public $store_rules;//存储验证规则
    public $update_rules;//更新表单验证规则
    public $model;
    public $help;
    public $table;
    public $DataModel;//新创建一个数据模型

    /*
    |-------------------------------------------------------------------------------
    |                .__                    __                        
    |        ______ |  |__ ______  _______/  |_  ___________   ____  
    |        \____ \|  |  \\____ \/  ___/\   __\/  _ \_  __ \_/ __ \ 
    |        |  |_> >   Y  \  |_> >___ \  |  | (  <_> )  | \/\  ___/ 
    |        |   __/|___|  /   __/____  > |__|  \____/|__|    \___  >
    |        |__|        \/|__|       \/                          \/ 
    |
    |-------------------------------------------------------------------------------
    |   相关的属性         相关说明
    |-------------------------------------------------------------------------------
    |   model            模型名称
    |   page             当前页的一级权限名称
    |   table            当前需要操作的数据表
    |   DataModel        生成一个全新空的数据模型 用于添加新纪录的时候赋值
    |   store_rules      添加新纪录时候的验证规则
    |   update_rules     更新记录时候的验证规则
    |-------------------------------------------------------------------------------
    |   相关函数          相关说明
    |-------------------------------------------------------------------------------   
    |   get_model($id)   获取当前模型
    |   keywords()       设置ajax搜索表单中需要参与搜索的数据库字段 一维数组的形式
    |   set_data_col     设置后台数据表格需要显示的数据库字段
    |   getData($data)   对tableData返回的数据进行格式化
    |   searchData()     设置生成搜索表单的参数
    |   searchInfo()     设置ajax排序js文件所需要的json格式参数
    |   FormData()       设置生成添加新记录的表单参数
    |   EditData($model) 设置生成编辑记录表单的参数
    |-------------------------------------------------------------------------------
    */
    function __construct(){

        parent::__construct();


        //设置参数
        $this->model                   = 'region_shipping'; 
        $this->page                    = 'config';
        //设置连接和名称
        $this->urlInit();
        //设置数据表
        $this->table                   = 'region_shipping';
        //设置数据模型
        $this->DataModel               = new RegionShipping();
        //新添加数据验证规则
        $this->store_rules             = [

                                            'shipping_id'       =>'required',
                                            'region_id'         =>'required',
                                            'fee'               =>'required',

        ];
        //更新数据验证规则
        $this->update_rules             = [

                                            'shipping_id'     =>'required',
                                            'region_id'       =>'required',
                                            'fee'             =>'required',

        ];

        //初始化帮助函数 不需要修改
        $this->HelpInit();
        //初始化工厂控制器 不需要修改
        $this->CtlInit();

    } 

    /*
    |-------------------------------------------------------------------------------
    |
    | 生成数据模型
    |
    |-------------------------------------------------------------------------------
    */
    public function get_model($id){

        return RegionShipping::find($id);
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 设置搜索关键词
    |
    |-------------------------------------------------------------------------------
    */
    public function keywords(){

        return ['region_id','shipping_id'];
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 设置需要显示的数据库字段
    |
    |-------------------------------------------------------------------------------
    */
    public function set_data_col(){

        return [
                    [   'col_name'        =>'id', //数据表中对应的字段
                        'alias_name'      =>'id', //别名 用于格式化数据
                        'col_value'       =>'编号',//数据表中字段对应的中文名称
                        'width'           =>'100px',//在表格中的宽度
                    ],
                    [ 
                        'col_name'        =>'shipping_id',
                        'alias_name'      =>'shipping_name',
                        'col_value'       =>'快递名称',
                        'width'           =>'',
                    ],
                    [ 
                        'col_name'        =>'region_id',   
                        'alias_name'      =>'region_name',          
                        'col_value'       =>'地区名称',  
                        'width'           =>'',
                    ],
                    [ 
                        'col_name'        =>'fee',
                        'alias_name'      =>'fee',
                        'col_value'       =>'快递费用',
                        'width'           =>'',
                    ],
                    
                    
                    
                    [ 
                        'col_name'        =>'sort_order',
                        'alias_name'      =>'sort_order',
                        'col_value'       =>'排序', 
                        'width'           =>'',
                    ],
        ];
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

            $model                        = RegionShipping::find($value['id']);
            //alias赋值
            $data[$key]['region_name']    = $model->region->region_name;
            $data[$key]['shipping_name']  = $model->shipping->shipping_name;

            //操作链接
            $data[$key]['edit_url']        = Common::get_resource_edit_url($this->list_url,$value['id']);
            $data[$key]['del_url']         = Common::get_del_url($this->del_url,$value['id']);
            $data[$key]['preview_url']     = '';
        }

        return $data;
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
                        'type'          => 'select',
                        'field'         => 'shipping_id',
                        'name'          => '快递名称',
                        'option_list'   =>  Shipping::option_list(),
                        'selected_name' =>'请选择',
                        'selected_value'=> '' ,
                        'id'            => 'shipping_id',
                    ],
                    

                    [
                        'type'          => 'select',
                        'field'         => 'region_id',
                        'name'          => '地区',
                        'option_list'   => Region::option_list(),
                        'selected_name' =>'请选择',
                        'selected_value'=> '' ,
                        'id'            => 'region_id',
                    ],

                    

                    [
                        'type'          => 'button',
                        'name'          => '搜索',
                        'id'            => 'search-btn',
                        'back_url'      => url($this->list_url),
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
                                    ['field'=>'shipping_id','value'=>''],
                                    ['field'=>'region_id','value'=>''],
                                   
                    ],

                    'fieldRow'=>[


                    ],

                    'whereIn'=>[],
        ];


        return  json_encode($row,JSON_UNESCAPED_UNICODE);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 添加商品 生成form表单的配置参数
    |
    |-------------------------------------------------------------------------------
    */
    public function FormData(){

        return [

                    //下拉选择表单
                     [
                        'type'          => 'select',
                        'field'         => 'shipping_id',
                        'name'          => '快递公司名称',
                        'option_list'   => Shipping::option_list(),
                        'selected_name' =>'请选择',
                        'selected_value'=> '' ,
                        'id'            => 'shipping_id',
                    ],

                    //下拉选择表单
                     [
                        'type'          => 'select',
                        'field'         => 'region_id',
                        'name'          => '地区',
                        'option_list'   => Region::option_list(),
                        'selected_name' =>'请选择',
                        'selected_value'=> '' ,
                        'id'            => 'region_id',
                    ],

                   
                    [
                        'type'          =>'text',
                        'field'         =>'fee',
                        'name'          =>'运费',
                        'value'         => 0,
                        'id'            =>'fee',
                    ],
                    
                    [
                        'type'          =>'text',
                        'field'         =>'sort_order',
                        'name'          =>'排序',
                        'value'         =>0,
                        'id'            =>'sort_order',
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
    | 编辑商品 生成form表单的配置参数
    |
    |-------------------------------------------------------------------------------
    */
    public function EditData($model){

        return [

                    //下拉选择表单
                     [
                        'type'          => 'select',
                        'field'         => 'shipping_id',
                        'name'          => '快递公司名称',
                        'option_list'   => Shipping::option_list(),
                        'selected_name' => $model->shipping->shipping_name,
                        'selected_value'=> $model->shipping_id ,
                        'id'            => 'shipping_id',
                    ],

                    //下拉选择表单
                     [
                        'type'          => 'select',
                        'field'         => 'region_id',
                        'name'          => '地区',
                        'option_list'   => Region::option_list(),
                        'selected_name' => $model->region->region_name,
                        'selected_value'=> $model->region_id ,
                        'id'            => 'region_id',
                    ],

                   
                    [
                        'type'          =>'text',
                        'field'         =>'fee',
                        'name'          =>'运费',
                        'value'         => $model->fee,
                        'id'            =>'fee',
                    ],
                    
                    [
                        'type'          =>'text',
                        'field'         =>'sort_order',
                        'name'          =>'排序',
                        'value'         =>$model->sort_order,
                        'id'            =>'sort_order',
                    ],
                    
                    [
                        'type'          =>'hidden',
                        'field'         =>'id',
                        'value'         =>$model->id,
                        'id'            =>'id'
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
                        'value'         => '确认更新',
                        'id'            => 'cat-submit',
                        'back_url'      => url($this->list_url),
                    ],
        ];

    }











    /*=======================  以下为辅佐函数 ======================================*/
}
