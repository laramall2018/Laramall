<?php

namespace App\Http\Controllers\Admin;


use App\Models\StyleModel;
use DB;
use File;
use HTML;
use Input;
use Phpstore\Grid\Common;
use Request;

class StyleController extends SuperController
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
        $this->model                   = 'style'; 
        $this->page                    = 'template';
        //设置连接和名称
        $this->urlInit();
        //设置数据表
        $this->table                   = 'style';
        //设置数据模型
        $this->DataModel               = new StyleModel();
        //新添加数据验证规则
        $this->store_rules             = [

                                            'style_name'            =>'required',
                                            'style_value'           =>'required',
                                            'style_css_file'        =>'required',

        ];
        //更新数据验证规则
        $this->update_rules             = [

                                           'style_name'            =>'required',
                                           'style_value'           =>'required',
                                           'style_css_file'        =>'required',

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

        return StyleModel::find($id);
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 设置搜索关键词
    |
    |-------------------------------------------------------------------------------
    */
    public function keywords(){

        return ['style_name'];
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
                        'col_name'        =>'style_name',
                        'alias_name'      =>'style_name',
                        'col_value'       =>'配色名称',
                        'width'           =>'',
                    ],
                    [ 
                        'col_name'        =>'style_value',   
                        'alias_name'      =>'style_value_str',          
                        'col_value'       =>'配色16进制值',  
                        'width'           =>'',
                    ],
                    [ 
                        'col_name'        =>'style_css_file',
                        'alias_name'      =>'style_css_file',
                        'col_value'       =>'配色css文件名称',
                        'width'           =>'',
                    ],

                    [ 
                        'col_name'        =>'is_checked',
                        'alias_name'      =>'is_checked_str',
                        'col_value'       =>'被选中',
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

            $model                         = StyleModel::find($value['id']);
            //alias赋值
            $data[$key]['style_value_str'] = $this->get_style_value_str($value['style_value']);
            $data[$key]['is_checked_str']  = $model->is_checked();

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
                        'type'          => 'text',
                        'field'         => 'style_name',
                        'name'          => '配色名称',
                        'value'         => '',
                        'id'            => 'style_name',
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
                                    ['field'=>'style_name','value'=>''],
                                    
                                   
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

                    
                   
                    [
                        'type'          =>'text',
                        'field'         =>'style_name',
                        'name'          =>'配色名称',
                        'value'         =>'',
                        'id'            =>'style_name',
                    ],

                    [
                        'type'          =>'text',
                        'field'         =>'style_value',
                        'name'          =>'颜色值',
                        'value'         =>'',
                        'id'            =>'style_value',
                    ],
                    [
                        'type'          =>'text',
                        'field'         =>'style_css_file',
                        'name'          =>'配色css文件名称',
                        'value'         =>'',
                        'id'            =>'style_css_file',
                    ],

                    //单选按钮表单
                    [
                        'type'          => 'radio',
                        'field'         => 'is_checked',
                        'name'          => '是否被选中',
                        'radio_row'     => $this->get_radio(),
                        'checked'       => 0,
                        'id'            => 'is_checked',
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

                    
                    [
                        'type'          =>'text',
                        'field'         =>'style_name',
                        'name'          =>'配色名称',
                        'value'         =>$model->style_name,
                        'id'            =>'style_name',
                    ],

                    [
                        'type'          =>'text',
                        'field'         =>'style_value',
                        'name'          =>'颜色值',
                        'value'         => $model->style_value,
                        'id'            =>'style_value',
                    ],
                    [
                        'type'          =>'text',
                        'field'         =>'style_css_file',
                        'name'          =>'配色css文件名称',
                        'value'         => $model->style_css_file,
                        'id'            =>'style_css_file',
                    ],

                    //单选按钮表单
                    [
                        'type'          => 'radio',
                        'field'         => 'is_checked',
                        'name'          => '是否被选中',
                        'radio_row'     => $this->get_radio(),
                        'checked'       => $model->is_checked,
                        'id'            => 'is_checked',
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


    /*
    |-------------------------------------------------------------------------------
    |
    | 生成颜色背景色块
    |
    |-------------------------------------------------------------------------------
    */
    public function get_style_value_str($style_value){

         $str       = '<span class="color-btn" style="background:'.$style_value.'">'
                      .$style_value 
                      .'</span>';
         return $str;
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 是否被选中
    |
    |-------------------------------------------------------------------------------
    */
    public function get_radio(){

        return [

                        ['name'=>'未选中','value'=>0],
                        ['name'=>'选中','value'=>1],
                        

            ];

    }


}
