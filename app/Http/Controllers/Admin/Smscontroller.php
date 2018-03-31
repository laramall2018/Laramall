<?php

namespace App\Http\Controllers\Admin;


use App\Models\Sms;
use DB;
use File;
use HTML;
use Input;
use Phpstore\Grid\Common;
use Request;

class SmsController extends SuperController
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
        $this->model                   = 'sms'; 
        $this->page                    = 'user';
        //设置连接和名称
        $this->urlInit();
        //设置数据表
        $this->table                   = 'sms';
        //设置数据模型
        $this->DataModel               = new Sms();
        //新添加数据验证规则
        $this->store_rules             = [

                                            'user_id'           =>'required',
                                            'sms_content'       =>'required',

        ];
        //更新数据验证规则
        $this->update_rules             = [

                                           'user_id'           =>'required',
                                           'sms_content'       =>'required',

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

        return Sms::find($id);
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 设置搜索关键词
    |
    |-------------------------------------------------------------------------------
    */
    public function keywords(){

        return ['sms_content','user_id'];
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
                        'col_name'        =>'user_id',
                        'alias_name'      =>'username',
                        'col_value'       =>'用户名称',
                        'width'           =>'',
                    ],
                    [ 
                        'col_name'        =>'admin_id',   
                        'alias_name'      =>'admin',          
                        'col_value'       =>'管理员名称',  
                        'width'           =>'',
                    ],
                    [ 
                        'col_name'        =>'sms_content',
                        'alias_name'      =>'sms_content',
                        'col_value'       =>'内容',
                        'width'           =>'',
                    ],
                    [ 
                        'col_name'        =>'post_time',
                        'alias_name'      =>'post_time_str',  
                        'col_value'       =>'时间',       
                        'width'           =>'',
                    ],
                    [ 
                        'col_name'        =>'ip',
                        'alias_name'      =>'ip',
                        'col_value'       =>'ip',
                        'width'           =>'',
                    ],
                    [ 
                        'col_name'        =>'user_status',
                        'alias_name'      =>'user_status_str',
                        'col_value'       =>'用户状态',    
                        'width'           =>'',
                    ],
                    [ 
                        'col_name'        =>'admin_status',
                        'alias_name'      =>'admin_status_str',
                        'col_value'       =>'管理员状态', 
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

            //alias赋值
            $data[$key]['username']         = $this->get_username($value['user_id']);
            $data[$key]['admin']            = $this->get_admin_username($value['admin_id']);
            $data[$key]['post_time_str']    = date('Y-m-d',$value['post_time']);
            $data[$key]['user_status_str']  = $this->get_status($value['user_status']);
            $data[$key]['admin_status_str'] = $this->get_status($value['admin_status']);


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
                        'field'         => 'sms_content',
                        'name'          => '短消息内容',
                        'value'         => '',
                        'id'            => 'sms_content',
                    ],

                    [
                        'type'          => 'select',
                        'field'         => 'user_id',
                        'name'          => '会员名称',
                        'option_list'   => $this->get_select_option_list(),
                        'selected_name' =>'请选择',
                        'selected_value'=> '' ,
                        'id'            => 'user_id',
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
                                    ['field'=>'sms_content','value'=>''],
                                    ['field'=>'user_id','value'=>''],
                                   
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
                        'field'         => 'user_id',
                        'name'          => '会员名称',
                        'option_list'   => $this->get_select_option_list(),
                        'selected_name' =>'请选择',
                        'selected_value'=> '' ,
                        'id'            => 'user_id',
                    ],

                    //下拉选择表单
                     [
                        'type'          => 'select',
                        'field'         => 'admin_id',
                        'name'          => '管理员名称',
                        'option_list'   => $this->get_admin_select_option_list(),
                        'selected_name' =>'请选择',
                        'selected_value'=> '' ,
                        'id'            => 'admin_id',
                    ],

                   
                    [
                        'type'          =>'textarea',
                        'field'         =>'sms_content',
                        'name'          =>'短消息内容',
                        'value'         =>'',
                        'id'            =>'sms_content',
                    ],
                     //单选按钮表单
                    [
                        'type'          => 'radio',
                        'field'         => 'user_status',
                        'name'          => '用户状态',
                        'radio_row'     => $this->get_radio(),
                        'checked'       => 0,
                        'id'            => 'user_status',
                    ],

                     //单选按钮表单
                    [
                        'type'          => 'radio',
                        'field'         => 'admin_status',
                        'name'          => '管理员状态',
                        'radio_row'     => $this->get_radio(),
                        'checked'       => 0,
                        'id'            => 'admin_status',
                    ],
                   

                     //表单中隐似插入的数据 不需要用户输入
                    [
                        'type'          => 'insert',
                        'field'         => 'post_time',
                        'value'         => time(),
                    ],

                    //表单中插入访客的ip
                    [
                        'type'          => 'insert',
                        'field'         => 'ip',
                        'value'         =>  Request::getClientIp(),
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
                        'field'         => 'user_id',
                        'name'          => '会员名称',
                        'option_list'   => $this->get_select_option_list(),
                        'selected_name' => $this->get_username($model->user_id),
                        'selected_value'=> $model->user_id ,
                        'id'            => 'user_id',
                    ],

                    //下拉选择表单
                     [
                        'type'          => 'select',
                        'field'         => 'admin_id',
                        'name'          => '管理员名称',
                        'option_list'   => $this->get_admin_select_option_list(),
                        'selected_name' => $this->get_admin_username($model->admin_id),
                        'selected_value'=> $model->admin_id ,
                        'id'            => 'admin_id',
                    ],

                   
                    [
                        'type'          =>'textarea',
                        'field'         =>'sms_content',
                        'name'          =>'短消息内容',
                        'value'         =>$model->sms_content,
                        'id'            =>'sms_content',
                    ],
                    [
                        'type'          =>'textarea',
                        'field'         =>'reply_content',
                        'name'          =>'管理员回复',
                        'value'         =>$model->reply_content,
                        'id'            =>'reply_content',
                    ],

                     //表单中隐似插入的数据 不需要用户输入
                    [
                        'type'          => 'insert',
                        'field'         => 'reply_time',
                        'value'         => time(),
                    ],

                     //单选按钮表单
                    [
                        'type'          => 'radio',
                        'field'         => 'user_status',
                        'name'          => '用户状态',
                        'radio_row'     => $this->get_radio(),
                        'checked'       => $model->user_status,
                        'id'            => 'user_status',
                    ],

                     //单选按钮表单
                    [
                        'type'          => 'radio',
                        'field'         => 'admin_status',
                        'name'          => '管理员状态',
                        'radio_row'     => $this->get_radio(),
                        'checked'       => $model->admin_status,
                        'id'            => 'admin_status',
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
    | 获取用户列表
    |
    |-------------------------------------------------------------------------------
    */
    public function get_select_option_list(){

         $row               = DB::table('users')->get();
         $str               = '<option value="">请选择</option>';

         foreach($row as $item){

            $str            .= '<option value="'.$item->id.'">'.$item->username.'</option>';
         }

         return $str;
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 获取用户列表
    |
    |-------------------------------------------------------------------------------
    */
    public function get_admin_select_option_list(){

         $row               = DB::table('admins')->get();
         $str               = '<option value="">请选择</option>';

         foreach($row as $item){

            $str            .= '<option value="'.$item->id.'">'.$item->username.'</option>';
         }

         return $str;
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 获取用户名称
    |
    |-------------------------------------------------------------------------------
    */
    public function get_username($user_id){

        $model      = DB::table('users')->where('id',$user_id)->first();

        if($model){

            return $model->username;
        }


        return '';
    }
   
   /*
    |-------------------------------------------------------------------------------
    |
    | 获管理员
    |
    |-------------------------------------------------------------------------------
    */
    public function get_admin_username($user_id){

        $model      = DB::table('admins')->where('id',$user_id)->first();

        if($model){

            return $model->username;
        }


        return '';
    }

   


    /*
    |-------------------------------------------------------------------------------
    |
    |  返回radio表单的list
    |
    |-------------------------------------------------------------------------------
    */
    public static function get_radio(){

            return [


                        ['name'=>'未查看','value'=>0],
                        ['name'=>'已查看','value'=>1],
                      
            ];
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  获取状态
    |
    |-------------------------------------------------------------------------------
    */
    public function get_status($tag){

        $tag        = intval($tag);
        $row        = ['未查看','查看'];

        if(in_array($tag,[0,1])){

            return $row[$tag];
        }


        return $row[0];
    }


}
