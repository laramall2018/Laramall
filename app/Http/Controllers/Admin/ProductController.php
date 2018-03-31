<?php

namespace App\Http\Controllers\Admin;


use App\Models\Goods;
use App\Models\Product;
use DB;
use File;
use HTML;
use Input;
use Phpstore\Grid\Common;
use Request;
use Validator;


class ProductController extends SuperController
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
        $this->model                   = 'product'; 
        $this->page                    = 'goods';
        //设置连接和名称
        $this->urlInit();
        //设置数据表
        $this->table                   = 'product';
        //设置数据模型
        $this->DataModel               = new Product();
        //新添加数据验证规则
        $this->store_rules             = [

                                            'goods_id'              =>'required',
                                            'goods_attr'            =>'required',
                                            'product_sn'            =>'required',
                                            'product_number'        =>'required',

        ];
        //更新数据验证规则
        $this->update_rules             = [

                                           'goods_id'              =>'required',
                                           'goods_attr'            =>'required',
                                           'product_sn'            =>'required',
                                           'product_number'        =>'required',

        ];

        //初始化帮助函数 不需要修改
        $this->HelpInit();
        //初始化工厂控制器 不需要修改
        $this->CtlInit();



    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  create操作
    |
    |-------------------------------------------------------------------------------
    */
    public function create(){

        $view                   = parent::create();
        $view->crud_js          = HTML::script('static/js/product.js');

        return $view;
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  store操作
    |
    |-------------------------------------------------------------------------------
    */
    public function store(){

        $ids        = request()->ids;

        if(count($ids) == 0){

            return $this->ctl->sysinfo->forbidden();
        }

        $rules      = [
                        'goods_id'      =>'required',
                        'product_number'=>'required',
                        'product_sn'    =>'required',
                      ];

        $validator  = Validator::make(request()->all(),$rules);

        if($validator->fails()){

            $this->ctl->sysinfo->put('validator',$validator);
            return $this->ctl->sysinfo->error();
         }

         $model             = new Product();


         //通过模型的fillable来直接存储数据
         $model->fill(request()->all())->save();

         $atrr              = [];
         foreach($ids as $id){

            $attr[]        = Request::input('goods_attr_ids_'.$id);
         }

         $model->goods_attr = implode("-", $attr);
         $model->save();

         return redirect($this->list_url);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  store操作
    |
    |-------------------------------------------------------------------------------
    */
    public function update(){

        $ids        = request()->ids;
        $id         = request()->id;
        $model      = Product::find($id);

        if(count($ids) == 0){

            return $this->ctl->sysinfo->forbidden();
        }

        if(empty($model)){

            return $this->ctl->sysinfo->forbidden();
        }

        $rules      = [
                        'goods_id'      =>'required',
                        'product_number'=>'required',
                        'product_sn'    =>'required',
                      ];

        $validator  = Validator::make(request()->all(),$rules);

        if($validator->fails()){

            $this->ctl->sysinfo->put('validator',$validator);
            return $this->ctl->sysinfo->error();
         }


         //通过模型的fillable来直接存储数据
         $model->fill(request()->all())->save();

         $atrr              = [];
         foreach($ids as $id){

            $attr[]        = Request::input('goods_attr_ids_'.$id);
         }

         $model->goods_attr = implode("-", $attr);
         $model->save();

         return redirect($this->list_url);
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  ajax操作生成下来表单
    |
    |-------------------------------------------------------------------------------
    */
    public function ajax(){

        $goods_id       = request()->goods_id;

        $goods          = Goods::find($goods_id);

        if(empty($goods)){

            return $this->toJSON(['info'=>'error','message'=>'商品模型为空']);
        }
        
        $attr_ids       = DB::table('goods_attr as ga')
                            ->leftjoin('attribute as a','a.id','=','ga.attr_id')
                            ->select('ga.attr_id','a.attr_name')
                            ->where('ga.goods_id','=',$goods_id)
                            ->where('a.attr_type','=',0)
                            ->orderBy('a.sort_order','asc')
                            ->groupBy('ga.attr_id')
                            ->get();


        $str            = $this->get_goods_attr_form($goods_id ,[]);

        return $this->toJSON(['attr_ids'=>$attr_ids,'str'=>$str]);
    }
                           


    

    /*
    |-------------------------------------------------------------------------------
    |
    | 生成数据模型
    |
    |-------------------------------------------------------------------------------
    */
    public function get_model($id){

        return Product::find($id);
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 设置搜索关键词
    |
    |-------------------------------------------------------------------------------
    */
    public function keywords(){

        return ['product_sn'];
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
                        'col_name'        =>'goods_id',
                        'alias_name'      =>'goods_name',
                        'col_value'       =>'商品名称',
                        'width'           =>'',
                    ],
                    [ 
                        'col_name'        =>'goods_attr',   
                        'alias_name'      =>'goods_attr_str',          
                        'col_value'       =>'属性链值',  
                        'width'           =>'',
                    ],
                    [ 
                        'col_name'        =>'product_sn',
                        'alias_name'      =>'product_sn',
                        'col_value'       =>'货品号',
                        'width'           =>'',
                    ],
                    [ 
                        'col_name'        =>'product_number',
                        'alias_name'      =>'product_number',
                        'col_value'       =>'货品库存',
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

            //alias赋值
            $data[$key]['goods_name']      = $this->get_goods_name_str($value['goods_id']);
            $data[$key]['goods_attr_str']  = $this->get_goods_attr($value['goods_attr']);

           

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
                        'field'         => 'product_sn',
                        'name'          => '货品编号',
                        'value'         => '',
                        'id'            => 'product_sn',
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
                                    ['field'=>'product_sn','value'=>''],
                                    
                                   
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
                        'field'         => 'goods_id',
                        'name'          => '商品名称',
                        'option_list'   =>  $this->get_goods_select_option_list(),
                        'selected_name' =>'请选择',
                        'selected_value'=> 0 ,
                        'id'            => 'goods_id',
                    ],
                    [
                        'type'          =>'div',
                        'name'          =>'用于放置ajax生成的表单信息',
                        'id'            =>'goods_attr',
                        'value'         =>'',
                    ],

                    [
                        'type'          =>'text',
                        'field'         =>'product_sn',
                        'name'          =>'货品货号',
                        'value'         =>'',
                        'id'            =>'product_sn',
                    ],
                    [
                        'type'          =>'text',
                        'field'         =>'product_number',
                        'name'          =>'货品库存',
                        'value'         =>'',
                        'id'            =>'product_number',
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
                        'field'         => 'goods_id',
                        'name'          => '商品名称',
                        'option_list'   =>  $this->get_goods_select_option_list(),
                        'selected_name' => $model->goods->goods_name,
                        'selected_value'=> $model->goods_id ,
                        'id'            => 'goods_id',
                    ],
                    [
                        'type'          =>'div',
                        'name'          =>'用于放置ajax生成的表单信息',
                        'id'            =>'goods_attr',
                        'value'         =>$this->get_edit_form($model),
                    ],

                    [
                        'type'          =>'text',
                        'field'         =>'product_sn',
                        'name'          =>'货品货号',
                        'value'         =>$model->product_sn,
                        'id'            =>'product_sn',
                    ],
                    [
                        'type'          =>'text',
                        'field'         =>'product_number',
                        'name'          =>'货品库存',
                        'value'         =>$model->product_number,
                        'id'            =>'product_number',
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
    | 获取商品名称
    |
    |-------------------------------------------------------------------------------
    */
    public function get_goods_name_str($goods_id){

        $goods          = Goods::find($goods_id);
        $str            = '';

        if(empty($goods)){

            return $str;
        }

        $str            = '<a href="'.$goods->url().'" target="_blank">'.$goods->goods_name.'</a>';

        return $str;
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 获取包含2个单选属性的商品列表
    |
    |-------------------------------------------------------------------------------
    */
    public function get_goods_select_option_list(){

        $data               = DB::table('goods_attr as ga')
                                ->leftjoin('goods as g','g.id','=','ga.goods_id')
                                ->groupBy('ga.goods_id')
                                ->select('g.id','g.goods_name')
                                ->get();

        $str                = '';

        foreach($data as $item){

            if($this->check_goods_is_product($item->id)){

                $str            .= '<option value="'.$item->id.'">'.$item->goods_name.'</option>';
            }
        }

        return $str;

    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 检测商品是否包含2个单选属性
    |
    |-------------------------------------------------------------------------------
    */
    public function check_goods_is_product($goods_id){

        $res            = DB::table('goods_attr as ga')
                            ->leftjoin('attribute as a','ga.attr_id','=','a.id')
                            ->where('ga.goods_id',$goods_id)
                            ->where('a.attr_type',0)
                            ->select('ga.attr_id')
                            ->get();
        $attr_ids       = [];

        if(empty($res)){

            return false;
        }

        foreach($res as $item){

             if(!in_array($item->attr_id ,$attr_ids)){

                $attr_ids[]     = $item->attr_id;
             }
        }

        if(count($attr_ids) == 2){

            return true;
        }

        return false;
    }




    /*
    |-------------------------------------------------------------------------------
    |
    |  获取属性字符串
    |
    |-------------------------------------------------------------------------------
    */
    public function get_goods_attr($goods_attr){

        if(empty($goods_attr)){

            return '';
        }

        $arr        = explode('-',$goods_attr);
        $arr2       = [];
        $str        = '';

        foreach($arr as $item){

            $model      = DB::table('goods_attr')->where('id',$item)->first();

            if($model){

                $arr2[] = $model->attr_value;
            }
        }

        if($arr2){

            $str       = implode("-", $arr2);
        }

        return $str;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   根据商品的编号 获取该商品所有的单选属性值列表  
    |
    |-------------------------------------------------------------------------------
    */
    public function get_goods_attr_form($goods_id ,Array $checked_arr){

            
        //首先获取该商品的所有单选属性名称列表
        $attribute              = DB::table('goods_attr as ga')
                                    ->leftjoin('attribute as a','a.id','=','ga.attr_id')
                                    ->select('ga.attr_id','a.attr_name')
                                    ->where('ga.goods_id','=',$goods_id)
                                    ->where('a.attr_type',0)
                                    ->groupBy('ga.attr_id')
                                    ->get();
        //初始化表单字符串
        $str                    = '';
        //初始化表单帮助函数
        $form                   = new \Phpstore\Crud\TemplateForm();

        foreach($attribute as $key=>$item){


             //获取商品指定属性名称的 商品属性值
             $attr           = DB::table('goods_attr')
                                ->where('goods_id',$goods_id)
                                ->where('attr_id',$item->attr_id)
                                ->get();

            //生成单选表单的值的数组
            $radio_row      = [];

            foreach($attr as $k=>$v){

                $radio_row[]    = ['name'=>$v->attr_value,'value'=>$v->id];
            }

            $form->put('field','goods_attr_ids_'.$item->attr_id);
            $form->put('name',$item->attr_name);
            $form->put('radio_row',$radio_row);

            if(count($checked_arr) == 0){

                $form->put('checked',$radio_row[0]['value']);
            }
            else{

                $form->put('checked',$checked_arr[$key]);
            }

            $str           .= $form->radio();
            $str           .= '<input type="hidden" name="ids[]" value="'.$item->attr_id.'">';

        }

        return $str;

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   获取编辑表单的商品属性字符串表单列表
    |
    |-------------------------------------------------------------------------------
    */
    public function get_edit_form($model){

        $str                = '';
        if(empty($model)){

            return $str;
        }

        $goods_id                   = $model->goods_id;
        $goods_attr                 = $model->goods_attr;

        if(empty($goods_attr)){

            return $str;
        }

        //把字符串转化成数组
        $arr                        = explode('-',$goods_attr);

        return $this->get_goods_attr_form($goods_id ,$arr);
    }



}
