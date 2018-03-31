<?php

namespace App\Http\Controllers\Admin;


use App\Models\Message;
use Auth;
use DB;
use File;
use HTML;
use Input;
use Phpstore\Grid\Common;
use Request;

class MessageController extends SuperController
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
    /*
    |-------------------------------------------------------------------------------
    |
    | 构造函数
    |
    |-------------------------------------------------------------------------------
    */
    function __construct(){

        parent::__construct();


        //设置参数
        $this->model                   = 'message';
        $this->page                    = 'user';
         //设置连接和名称
        $this->urlInit();
        //设置数据表
        $this->table                   = 'message';
        //设置数据模型
        $this->DataModel               = new Message();

        //新添加数据验证规则 
        $this->store_rules             = [

                                            'username'   =>'required',
                                            'email'      =>'required|email',
                                            'content'    =>'required',
                                            'type'       =>'required',
                                          

        ];
        //更新数据验证规则
        $this->update_rules             = [

                                            'username'   =>'required',
                                            'email'      =>'required|email',
                                            'content'    =>'required',
                                            'type'       =>'required',

        ];

        //初始化帮助函数
        $this->HelpInit();

        //初始化工厂控制器
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

        $id             = intval($id);
        return Message::find($id);
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 设置搜索关键词
    |
    |-------------------------------------------------------------------------------
    */
    public function keywords(){

        return ['username','email','content',];
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

        [ 'col_name'=>'id',         'alias_name'=>'id',             'col_value'=>'编号',      'width'=>'100px'],
        [ 'col_name'=>'username',   'alias_name'=>'username',       'col_value'=>'用户名称',   'width'=>'',],
        [ 'col_name'=>'email',      'alias_name'=>'email',          'col_value'=>'电子邮箱',    'width'=>'',],
        [ 'col_name'=>'content',    'alias_name'=>'content',        'col_value'=>'内容',       'width'=>'',],
        [ 'col_name'=>'rank',       'alias_name'=>'rank',           'col_value'=>'等级',       'width'=>'',],
        [ 'col_name'=>'status',     'alias_name'=>'status_str',     'col_value'=>'状态',       'width'=>'',],


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
           
            $data[$key]['status_str']     = $this->get_status($value['status']);
           

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
                        'field'         => 'username',
                        'name'          => '用户名称',
                        'value'         => '',
                        'id'            => 'username',
                    ],
                    [
                        'type'          => 'text',
                        'field'         => 'email',
                        'name'          => '电子邮件',
                        'value'         => '',
                        'id'            => 'email',
                    ],
                    [
                        'type'          => 'text',
                        'field'         => 'content',
                        'name'          => '内容',
                        'value'         => '',
                        'id'            => 'content',
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
                                    ['field'=>'username','value'=>''],
                                    ['field'=>'email','value'=>''],
                                    ['field'=>'content','value'=>''],
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
                        'field'         => 'username',
                        'name'          => '会员名称',
                        'option_list'   => $this->get_select_option_list(),
                        'selected_name' =>'请选择',
                        'selected_value'=> '' ,
                        'id'            => 'username',
                    ],

                    //下拉选择表单
                     [
                        'type'          => 'select',
                        'field'         => 'type',
                        'name'          => '留言类型',
                        'option_list'   => $this->get_type_select_option_list(),
                        'selected_name' =>'请选择',
                        'selected_value'=> '' ,
                        'id'            => 'type',
                    ],

                    //下拉选择表单
                     [
                        'type'          => 'select',
                        'field'         => 'id_value',
                        'name'          => '待评价商品',
                        'option_list'   => $this->get_goods_select_option_list(),
                        'selected_name' =>'请选择',
                        'selected_value'=> '' ,
                        'id'            => 'id_value',
                    ],
                    [
                        'type'          =>'text',
                        'field'         =>'email',
                        'name'          =>'电子邮件',
                        'value'         =>'',
                        'id'            =>'email',
                    ],
                    [
                        'type'          =>'textarea',
                        'field'         =>'content',
                        'name'          =>'留言内容',
                        'value'         =>'',
                        'id'            =>'content',
                    ],

                    //单选按钮表单
                    [
                        'type'          => 'radio',
                        'field'         => 'rank',
                        'name'          => '等级',
                        'radio_row'     => $this->get_radio(),
                        'checked'       => 1,
                        'id'            => 'rank',
                    ],

                     //表单中隐似插入的数据 不需要用户输入

                    [
                        'type'          => 'insert',
                        'field'         => 'add_time',
                        'value'         => time(),
                    ],

                    //表单中插入访客的ip
                    [
                        'type'          => 'insert',
                        'field'         => 'admin_ip',
                        'value'         =>  Request::getClientIp(),
                     ],

                     //单选按钮表单
                    [
                        'type'          => 'radio',
                        'field'         => 'status',
                        'name'          => '状态',
                        'radio_row'     => $this->get_status_radio(),
                        'checked'       => 0,
                        'id'            => 'status',
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
                        'field'         => 'username',
                        'name'          => '会员名称',
                        'option_list'   => $this->get_select_option_list(),
                        'selected_name' =>$model->username,
                        'selected_value'=> $model->username ,
                        'id'            => 'username',
                    ],

                    //下拉选择表单
                     [
                        'type'          => 'select',
                        'field'         => 'type',
                        'name'          => '留言类型',
                        'option_list'   => $this->get_type_select_option_list(),
                        'selected_name' => $model->type,
                        'selected_value'=> $model->type ,
                        'id'            => 'type',
                    ],

                    //下拉选择表单
                     [
                        'type'          => 'select',
                        'field'         => 'id_value',
                        'name'          => '待评价商品',
                        'option_list'   => $this->get_goods_select_option_list(),
                        'selected_name' => ($model->goods)? $model->goods->goods_name : '',
                        'selected_value'=> $model->id_value ,
                        'id'            => 'id_value',
                    ],
                    [
                        'type'          =>'text',
                        'field'         =>'email',
                        'name'          =>'电子邮件',
                        'value'         =>$model->email,
                        'id'            =>'email',
                    ],
                    [
                        'type'          =>'textarea',
                        'field'         =>'content',
                        'name'          =>'留言内容',
                        'value'         =>$model->content,
                        'id'            =>'content',
                    ],

                    [
                        'type'          =>'textarea',
                        'field'         =>'reply',
                        'name'          =>'管理员回复',
                        'value'         => $model->reply,
                        'id'            =>'reply',
                    ],
                    [
                        'type'          => 'text',
                        'field'         => 'admin',
                        'name'          => '管理员',
                        'value'         => Auth::user('admin')->username,
                        'id'            =>'admin',
                    ],

                    [
                        'type'          =>'text',
                        'field'         =>'front_ip',
                        'name'          =>'用户登录ip',
                        'value'         =>$model->front_ip,
                        'id'            =>'front_ip',
                    ],
                    

                    //单选按钮表单
                    [
                        'type'          => 'radio',
                        'field'         => 'rank',
                        'name'          => '等级',
                        'radio_row'     => $this->get_radio(),
                        'checked'       => $model->rank,
                        'id'            => 'rank',
                    ],

                    

                     //单选按钮表单
                    [
                        'type'          => 'radio',
                        'field'         => 'status',
                        'name'          => '状态',
                        'radio_row'     => $this->get_status_radio(),
                        'checked'       => $model->status,
                        'id'            => 'status',
                    ],

                    [
                        'type'          => 'insert',
                        'field'         => 'reply_time',
                        'value'         => time(),
                    ],

                    [
                        'type'          => 'insert',
                        'field'         => 'admin_ip',
                        'value'         => Request::getclientIp(),
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


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取状态
    |
    |-------------------------------------------------------------------------------
    */
    public function get_status($status){

        $row        = ['审核中','已通过'];
        $status     = intval($status);

        if(in_array($status,[0,1])){

            return $row[$status];
        }

        return $row[0];
    }

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

            $str            .= '<option value="'.$item->username.'">'.$item->username.'</option>';
         }

         return $str;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取留言类型
    |
    |-------------------------------------------------------------------------------
    */
    public function get_type_select_option_list(){

         $row               = ['留言','建议','意见','评价'];
         $str               = '<option value="">请选择</option>';

         foreach($row as $item){

            $str            .= '<option value="'.$item.'">'.$item.'</option>';
         }

         return $str;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取商品列表
    |
    |-------------------------------------------------------------------------------
    */
    public function get_goods_select_option_list(){

         $row               = DB::table('goods')->where('is_on_sale',1)->get();
         $str               = '<option value="">请选择</option>';

         foreach($row as $item){

            $str            .= '<option value="'.$item->id.'">'.$item->goods_name.'</option>';
         }

         return $str;
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


                        ['name'=>'1','value'=>1],
                        ['name'=>'2','value'=>2],
                        ['name'=>'3','value'=>3],
                        ['name'=>'4','value'=>4],
                        ['name'=>'5','value'=>5],
                       
            ];
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  返回status radio
    |
    |-------------------------------------------------------------------------------
    */
    public static function get_status_radio(){

            return [


                        ['name'=>'审核中','value'=>0],
                        ['name'=>'已通过','value'=>1],
                       
                       
            ];
    }
}
