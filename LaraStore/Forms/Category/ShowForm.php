<?php

namespace LaraStore\Forms\Category;
use App\Models\Category;
use LaraStore\Forms\Form;
use App\Http\Controllers\Api\ApiController as Api;

class ShowForm extends Form{

	public $api;
	/*
    |-------------------------------------------------------------------------------
    |
    | 表单验证规则
    |
    |-------------------------------------------------------------------------------
    */
    protected $rules = [
        
    ];


    /*
    |-------------------------------------------------------------------------------
    |
    | 表单验证规则提示信息
    |
    |-------------------------------------------------------------------------------
    */
    protected $messages = [
       	
    ];


    /*
    |-------------------------------------------------------------------------------
    |
    | 构造函数
    |
    |-------------------------------------------------------------------------------
    */
    public function __construct(Api $api , $id){
       $this->api           = $api;
       $this->id            = $id;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   检测模型是否存在
    |
    |-------------------------------------------------------------------------------
    */
    public function isEmpty(){

    	return (empty(Category::find($this->id)))? true:false;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   isValid
    |
    |-------------------------------------------------------------------------------
    */
    public function isValid(){

        return ($this->isEmpty())? false : true;
    }

    

    /*
    |-------------------------------------------------------------------------------
    |
    |  成功后返回
    |
    |-------------------------------------------------------------------------------
    */
    public function successRespond(){

    	$tag 				= 'success';
    	$info 				= 'success';
        $model  			= Category::find($this->id);
        $price 				= $model->price();
        $brand 				= $model->brand();
        $goods_list 		= $model->goods_list();
        $attr               = $model->attr();
        $field              = $model->field();
        $page               = $model->presenter()->page()->handle();
        $current_page       = $page['current_page'];
        $total              = $page['total'];
        $per_page           = $page['per_page'];
        $last_page          = $page['last_page'];
        $number             = $page['number'];

        $cat_id             = $this->id;
        $brand_id           = 0;
        $brand_name         = '';
        $goods_attr_ids     = [];
        $goods_attrs        = [];
        $goods_field_ids    = [];
        $goods_fields       = [];
        $max                = 0;
        $min                = 0;
        $sort_name          = 'id';
        $sort_value         = 'asc';

    	return $this->api->respond(['data'=>compact($this->field())]);
    	
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |  返回数据字段数组
    |
    |-------------------------------------------------------------------------------
    */
    public function field(){

        return [ 
                                            
                'tag',//执行结果
                'info',//弹出信息
                'goods_list',
                'page',
                'price',
                'brand',
                'attr',
                'field',
                'number',
                'goods_attr_ids',//被选中的商品属性值编号数组
                'goods_attrs',
                'goods_field_ids',//被选中的商品规格值编号数组
                'goods_fields',//规格值
                'max',//价格区间最大值
                'min',//价格区间最小值
                'cat_id',//分类编号
                'brand_id',//品牌编号
                'brand_name',//品牌名称
                'sort_name',
                'sort_value',
                'current_page',
                'last_page',
                'per_page',
                'total',
        ];
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  验证未通过返回错误信息
    |
    |-------------------------------------------------------------------------------
    */
    public function errorRespond(){

    	if($this->isEmpty()){
            $info               = '模型异常';
    		return $this->api->respondCommonError($info);
    	}
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 处理数据库相关操作
    |
    |-------------------------------------------------------------------------------
    */
    public function persist()
    {
         return true;
    }
}