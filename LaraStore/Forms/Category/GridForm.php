<?php

namespace LaraStore\Forms\Category;
use App\Models\Category;
use App\Models\GoodsAttr;
use App\Models\GoodsField;
use LaraStore\Forms\Form;
use App\Http\Controllers\Api\ApiController as Api;
use LaraStore\Grid\Grid;
use Phpstore\Grid\Page;
use LaraStore\Forms\Category\GridPresenter;

class GridForm{

	protected $api;
    protected $max;
    protected $min;
    protected $brand_id;
    protected $cat_id;
    protected $goods_attr_ids;
    protected $goods_field_ids;
    protected $sort_name;
    protected $sort_value;
    protected $current_page;
    protected $total;
    protected $per_page;
    protected $last_page;
    protected $category;
    protected $page;
    protected $grid;

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
    public function __construct(Api $api){
       
       $this->api           = $api;

    }



    /*
    |-------------------------------------------------------------------------------
    |
    |  设置参数
    |
    |-------------------------------------------------------------------------------
    */
    public function put($key , $value){

        $this->$key         = $value;
        return $this;
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |  设置参数
    |
    |-------------------------------------------------------------------------------
    */
    public function presenter(){

        return  new GridPresenter($this);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取参数
    |
    |-------------------------------------------------------------------------------
    */
    public function attributes(){

        return json_decode(request()->param);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   检测模型是否存在
    |
    |-------------------------------------------------------------------------------
    */
    public function isEmpty(){

    	return (empty(Category::find($this->attributes()->cat_id)))? true:false;
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
        $model  			= Category::find($this->attributes()->cat_id);
        $goods_list         = $this->presenter()->cache()->toJSON();
        $goods_attrs        = GoodsAttr::getList($this->presenter()->get('goods_attr_ids'));
        $goods_fields       = GoodsField::getList($this->presenter()->get('goods_field_ids'));
        $number             = $this->presenter()->page()->number();
        $page               = $this->presenter()->grid()->page();
        $current_page       = $this->presenter()->get('current_page');
        $per_page           = $this->presenter()->get('per_page');
        $last_page          = $this->presenter()->get('last_page');
        $total              = $this->presenter()->get('total');

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
                                            
                'tag',
                'info',
                'goods_list',
                'goods_attrs',
                'goods_fields',
                'page',
                'number',
                'current_page',
                'per_page',
                'last_page',
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