<?php

namespace LaraStore\Grid;

use Phpstore\Grid\Page;
use App\Models\Category;
use App\Models\Brand;
use App\Models\GoodsAttr;
use App\Models\GoodsField;
use App\Models\Goods;
use DB;

class Grid{

 	/*
	|-------------------------------------------------------------------------------
	|
	|  分类页grid组件
	|
	|-------------------------------------------------------------------------------
	*/
	protected $max;
	protected $min;
	protected $brand_id;
	protected $category;
	protected $sort_name;
	protected $sort_value;
	protected $page;
	protected $goods_attr_ids;
	protected $goods_field_ids;
	protected $query;

	/*
	|-------------------------------------------------------------------------------
	|
	|  构造函数
	|
	|-------------------------------------------------------------------------------
	*/
	public function __construct(Category $category){
		$this->category  	= $category;
	}


	/*
	|-------------------------------------------------------------------------------
	|
	|  设置参数
	|
	|-------------------------------------------------------------------------------
	*/
	public function put($key , $value){
		$this->$key 	= $value;
		return $this;
	}


	/*
	|-------------------------------------------------------------------------------
	|
	|  获取对象格式的 商品列表结果
	|  baseQuery       --- 基础查询
	|  catQuery 	   --- 分类编号范围查询
	|  brandQuery      --- 品牌编号范围查询
	|  priceQuery 	   --- 价格区间查询
	|  attrQuery 	   --- 属性组查询
	|  pageQuery 	   --- 分页-排序-除重复查询
	| 
	|
	|-------------------------------------------------------------------------------
	*/
	public function handle(){
		
		return $this->baseQuery() 		//基础查询
					->catQuery()  		//分类查询
					->brandQuery()		//品牌查询
					->priceQuery()		//价格区间查询
					->attrQuery()		//属性查询
					->fieldQuery()		//规格查询
					->withQuery()       //指定查询哪些字段
					->sortQuery()       //排序查询
					->uniqueQuery()     //去除重复字段
					->pageQuery()		//分页查询
					->getQuery();       //获取最后数据
	}


	/*
	|-------------------------------------------------------------------------------
	|
	|  获取商品总数量
	|
	|-------------------------------------------------------------------------------
	*/
	public function total(){

		$query  = $this->baseQuery()
					   ->catQuery()
					   ->brandQuery()
					   ->priceQuery()
					   ->attrQuery()
					   ->fieldQuery()
					   ->uniqueQuery()
					   ->getQuery();
		return count($query);
	}


	/*
	|-------------------------------------------------------------------------------
	|
	|  获取json格式的结构体
	|
	|-------------------------------------------------------------------------------
	*/
	public function toJSON(){
		return $this->toArray();
	}




	/*
	|-------------------------------------------------------------------------------
	|
	|  基础查询
	|
	|-------------------------------------------------------------------------------
	*/
	public function baseQuery(){
		
		$this->query 	=  DB::table('goods');
		return $this;
	}



	/*
	|-------------------------------------------------------------------------------
	|
	|  分类查询
	|
	|-------------------------------------------------------------------------------
	*/
	public function catQuery(){
		
		$this->query 		= $this->query->whereIn('cat_id',$this->category->ids());
		return $this;
	}


	



	/*
	|-------------------------------------------------------------------------------
	|
	|  品牌是否存在
	|
	|-------------------------------------------------------------------------------
	*/
	public function hasBrand(){

		return empty(Brand::find($this->brand_id))? false :true;
	}


	/*
	|-------------------------------------------------------------------------------
	|
	|  品牌查询
	|
	|-------------------------------------------------------------------------------
	*/
	public function brandQuery(){

		if($this->hasBrand()){
			$this->query 	=  $this->query->where('brand_id',$this->brand_id);
		}
		return $this;
	}


	/*
	|-------------------------------------------------------------------------------
	|
	|  判断价格区间是否存在
	|
	|-------------------------------------------------------------------------------
	*/
	public function hasPrice(){
		return ($this->min > 0 && $this->max > 0 )? true:false;
	}


	/*
	|-------------------------------------------------------------------------------
	|
	|  价格区间条件搜索
	|
	|-------------------------------------------------------------------------------
	*/
	public function priceQuery(){

		return ($this->hasPrice())? $this->priceQueryHandle() : $this;
	}


	/*
	|-------------------------------------------------------------------------------
	|
	|  价格区间条件搜索 价格区间真正存在
	|
	|-------------------------------------------------------------------------------
	*/
	public function priceQueryHandle(){

		$this->query  = $this->query->where('shop_price','>=',$this->min)->where('shop_price','<=',$this->max);
		return $this;
	}


	/*
	|-------------------------------------------------------------------------------
	|
	|  属性搜索 判断属性是否存在
	|
	|-------------------------------------------------------------------------------
	*/
	public function hasAttr(){
		return (count($this->goods_attr_ids) > 0)? true :false;
	}

	/*
	|-------------------------------------------------------------------------------
	|
	|  判断是否有规格值数组
	|
	|-------------------------------------------------------------------------------
	*/
	public function hasField(){

		return (count($this->goods_field_ids) > 0) ? true :false;
	}


	/*
	|-------------------------------------------------------------------------------
	|
	|  把属性值编号转化成属性值名称  goods_attr_id  <=>  attr_value
	|
	|-------------------------------------------------------------------------------
	*/
	public function attr_value(){

		return GoodsAttr::getValueList($this->goods_attr_ids);
	}

	/*
	|-------------------------------------------------------------------------------
	|
	|  把规格值编号转化成规格值名称  goods_field_id  <=>  field_value
	|
	|-------------------------------------------------------------------------------
	*/
	public function field_value(){

		return collect($this->goods_field_ids)->map(function($item,$key){

					return ($model = GoodsField::find($item))? $model->field_value :'';
		});
	}



	/*
	|-------------------------------------------------------------------------------
	|
	|  属性搜索
	|
	|-------------------------------------------------------------------------------
	*/
	public function attrQuery(){

		return ($this->hasAttr())? $this->attrQueryHandle() : $this;
	}


	/*
	|-------------------------------------------------------------------------------
	|
	|  规格搜索
	|
	|-------------------------------------------------------------------------------
	*/
	public function fieldQuery(){

		return ($this->hasField())? $this->whereExistsQueryField() : $this;
	}


	/*
	|-------------------------------------------------------------------------------
	|
	|  属性搜索
	|
	|-------------------------------------------------------------------------------
	*/
	public function attrQueryHandle(){

		return $this->whereExistsQueryAttr();
		
	}


	


	/*
	|-------------------------------------------------------------------------------
	|
	|  属性搜索 当有多组属性的时候启用whereExists搜索  whereExistsQuery
	|
	|-------------------------------------------------------------------------------
	*/
	public function whereExistsQueryAttr(){

		$query   	= $this->query;
		foreach($this->attr_value() as $attr){

			$query  = $query->whereExists(function($q) use ($attr){

							$q->select(DB::raw(1))
							  ->from('goods_attr')
							  ->whereRaw('ps_goods_attr.goods_id = ps_goods.id')
							  ->where('goods_attr.attr_value',$attr);
			});
		}

		$this->query 	= $query;
		return  $this;
	}



	/*
	|-------------------------------------------------------------------------------
	|
	|  规格值搜索 当有多组规格值的时候启用whereExists搜索  whereExistsQuery
	|
	|-------------------------------------------------------------------------------
	*/
	public function whereExistsQueryField(){

		$query   	= $this->query;
		foreach($this->field_value() as $field_value){

			$query  = $query->whereExists(function($q) use ($field_value){

							$q->select(DB::raw(1))
							  ->from('goods_field')
							  ->whereRaw('ps_goods_field.goods_id = ps_goods.id')
							  ->where('goods_field.field_value',$field_value);
			});
		}

		$this->query  = $query;
		return $this;
	}



	/*
	|-------------------------------------------------------------------------------
	|
	|  把page中的值取出来 赋值给 $this
	|
	|-------------------------------------------------------------------------------
	*/
	public function boot(){

		$this->current_page  	= $this->page->get('current_page');
		$this->per_page 		= $this->page->get('per_page');
		$this->total 			= $this->page->get('total');
		$this->last_page 		= $this->page->get('last_page');

		if($this->current_page > $this->last_page){
			$this->current_page =1;
		}

	}


	/*
	|-------------------------------------------------------------------------------
	|
	|  获取skip的值
	|
	|-------------------------------------------------------------------------------
	*/
	public function skip(){
		$this->boot();
		return ($this->current_page <= $this->last_page)? ($this->current_page -1)* $this->per_page : 0;
	}



	/*
	|-------------------------------------------------------------------------------
	|
	|  withQuery 选择那些字段
	|
	|-------------------------------------------------------------------------------
	*/
	public function withQuery(){

		$this->query  	=  $this->query->select('*');
		return $this;
	}

	/*
	|-------------------------------------------------------------------------------
	|
	|  sortQuery 排序查询
	|
	|-------------------------------------------------------------------------------
	*/
	public function sortQuery(){

		$this->query   =  $this->query->orderBy($this->sort_name,$this->sort_value);
		return $this;
	}


	/*
	|-------------------------------------------------------------------------------
	|
	|  uniqueQuery 去掉重复数据
	|
	|-------------------------------------------------------------------------------
	*/
	public function uniqueQuery(){

		$this->query  	= $this->query->groupBy('id');
		return $this;
	}



	/*
	|-------------------------------------------------------------------------------
	|
	|  pageQuery
	|
	|-------------------------------------------------------------------------------
	*/
	public function pageQuery(){

		$this->query 	= $this->query->skip($this->skip())->take($this->per_page);
		return $this;
	}


	/*
	|-------------------------------------------------------------------------------
	|
	|  getQuery 获取值
	|
	|-------------------------------------------------------------------------------
	*/
	public function getQuery(){

		$this->query   	=  $this->query->get();
		return $this->query;
	}


	/*
    |-------------------------------------------------------------------------------
    |
    |  进一步格式化商品列表数据
    |
    |-------------------------------------------------------------------------------
    */
    public function toArray(){
        $arr        = [];
        foreach($this->handle() as $item){
        	$goods 				    = Goods::find($item->id);
            $arr[]  =[
                'id'                =>$goods->id,
                'goods_name'        =>$goods->goods_name,
                'short_goods_name'  =>str_limit($goods->goods_name,25,'..'),
                'cat_id'            =>$goods->cat_id,
                'brand_id'          =>$goods->brand_id,
                'shop_price'        =>$goods->shop_price,
                'thumb'             =>$goods->thumb(),
                'url'               =>$goods->url(),
                'gallerys'          =>$goods->presenter()->gallerys(),
            ];
        }
        return $arr;
    }



    /*
	|-------------------------------------------------------------------------------
	|
	|  获取page
	|
	|-------------------------------------------------------------------------------
	*/
	public function page(){

		return [

					'current_page'	=> $this->page->get('current_page'),
					'last_page'		=> $this->page->get('last_page'),
					'current_page'	=> $this->page->get('current_page'),
					'per_page'		=> $this->page->get('per_page'),
		];
	}
}

