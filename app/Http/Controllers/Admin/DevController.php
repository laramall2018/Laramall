<?php namespace App\Http\Controllers\Admin;

use File;
use HTML;
use Input;
use Phpstore\Base\Lang;
use Phpstore\Base\Sysinfo;
use Phpstore\Crud\Crud;
use Phpstore\Crud\FormHelp;
use Phpstore\Crud\FormToModel;
use Request;
use Validator;

class DevController extends BaseController{



    /*
    |-------------------------------------------------------------------------------
    |
    | 构造函数
    |
    |-------------------------------------------------------------------------------
    */

   
    public $page;
    public $tag;
    public $view;
    public $layout;
    public $form;
    public $crud;
    public $row;
    public $form_to_model;


    function __construct(){

        parent::__construct();
        $this->page                 = 'dev';
        $this->tag                  = 'databases';
        $this->crud                 = new Crud();
        $this->form_to_model        = new FormToModel();

        $this->sysinfo              = new Sysinfo();
        $this->sysinfo->put('url',HTML::link('admin/databases',Lang::get('back_databases')));
        $this->sysinfo->put('page',$this->page);
        $this->sysinfo->put('tag',$this->tag);

    }



    /*
    |-------------------------------------------------------------------------------
    |
    |  显示系统所有数据表 字段
    |
    |-------------------------------------------------------------------------------
    */
    public function index(){

        $view                       = $this->View('databases');
        $view->page                 = $this->page;
        $view->tag                  = $this->tag;
        $view->action_name          = Lang::get('databases_title');
        $current_url                = HTML::link('admin/databases',Lang::get('databases_title'));
        $view->path_url             = $this->get_path_url($current_url);
        
        $form                       = new FormHelp();
        //获取表格信息
        $form->put('col',$this->th());
        $form->put('data',$this->data());
        $table                      = $form->table();
        //输出带表格的porlet box
        $form->put('color','blue');
        $form->put('content',$table);
        $form->put('title',Lang::get('databases_title'));
        $view->portlet              = $form->portlet();

        //输出商品表格信息
        $table                      = $this->table();
        $form->put('col',['数据表字段','字段名称','字段类型']);
        $form->put('data',$table['ps_goods']);
        $goods_table                = $form->table();
        //输出带表格的portlet box
        $form->put('color','green');
        $form->put('content',$goods_table);
        $form->put('title','商品数据表ps_goods的字段');
        $view->portlet2             = $form->portlet();

        return $view;
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |  设置 数据表显示字段
    |
    |-------------------------------------------------------------------------------
    */
    public function data(){

        return [

                 ['field'=>'ps_goods','name'=>'商品数据表','info'=>'和商品相关的基础信息'],
                 ['field'=>'ps_category','name'=>'商品分类表','info'=>'和商品分类相关的信息'],
                 ['field'=>'ps_brand','name'=>'商品品牌表','info'=>'商品品牌相关的信息'],
                 ['field'=>'ps_attribute','name'=>'商品属性表','info'=>'记录商品属性的相关信息'],
                 
                
                    
        ];
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  设置具体数据表的每个字段信息
    |
    |-------------------------------------------------------------------------------
    */
    public function table(){

        return [

                    'ps_goods' => [

                                    ['field'=>'id','name'=>'编号','info'=>'int(10)'],
                                    ['field'=>'cat_id','name'=>'分类编号','info'=>'int(10)'],
                                    ['field'=>'goods_name','name'=>'商品名称','info'=>'varchar(255)'],
                                    ['field'=>'goods_name_style','name'=>'带样式的商品名称','info'=>'varchar(255)'],

                                  ],

        ];
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  返回th的字段数据
    |
    |-------------------------------------------------------------------------------
    */
    public function th(){

        return ['数据表','数据表名称','说明'];
    }



}