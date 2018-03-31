<?php namespace Phpstore\Front;

use Auth;
use App\Models\Cart;
use App\Models\Goods;
use App\Models\GoodsAttr;
use App\Models\UserAddress;
use App\Models\Shipping;
use App\Models\Payment;
use App\Models\Order;
use App\Models\Region;
use App\Models\OrderGoods;
use DB;
use Session;
use HTML;
use Form;
use Request;
use Phpstore\Grid\Page;
use App\Models\Category;
use Cache;

/*
|-------------------------------------------------------------------------------
|
|   处理分类页ajax排序
|
|-------------------------------------------------------------------------------
*/
class Grid{

	

	public $min;
	public $max;
	public $cat_id;
	public $page;
	public $brand_id;
	public $attr;
	public $sort_name;
	public $sort_value;
	public $goods_attr_ids;
	public $cacheKey;
	/*
	|----------------------------------------------------------------------------
	|
	|  构造函数
	|
	|----------------------------------------------------------------------------
	*/
	function __construct(){

		
		

	}


	/*
	|----------------------------------------------------------------------------
	|
	|  初始化赋值函数
	|
	|----------------------------------------------------------------------------
	*/ 
	public function put($key , $value){

		$this->$key 		= $value;
		if($key == 'goods_attr_ids'){
			$this->attr 	= $value;
		}

		return ($this->$key)? true:false;
	}


	/*
	|----------------------------------------------------------------------------
	|
	|  批量初始化
	|
	|----------------------------------------------------------------------------
	*/ 
	public function init($row){

		foreach($row as $key=>$value){

			$this->put($key,$value);
		}
	}


	/*
	|----------------------------------------------------------------------------
	|
	|  初始化cacheKey
	|
	|----------------------------------------------------------------------------
	*/ 
	public function getCacheKey(){

     $str   =  	  'get_category_page_goods_list_from_sort_key_is'
				  .'-'.$this->max
				  .'-'.$this->min
		 		  .'-'.$this->cat_id
		 		  .'-'.$this->brand_id
		 		  .'-'.$this->sort_name
		 		  .'-'.$this->sort_value
		 		  .'-'.$this->page->get('current_page')
		 		  .'-'.$this->page->get('last_page')
		 		  .'-'.$this->page->get('per_page')
		 		  .'-'.$this->page->get('total')
		 		  .'-'.implode('-',$this->attr);
	  return $str;
	}


	/*
	|----------------------------------------------------------------------------
	|
	|  获取值
	|
	|----------------------------------------------------------------------------
	*/ 
	public function get($key){

		if($this->$key){

			return $this->$key;
		}
		else{

			return '';
		}
	}



	/*
	|----------------------------------------------------------------------------
	|
	|	获取总记录数
	|
	|----------------------------------------------------------------------------
	*/
	public function  total(){


		if(empty($this->cat_id)){

			return false;
		}

		$cat 			= Category::find($this->cat_id);

		if(empty($cat)){

			return false;
		}

		//获取商品分类id以及所有子类id
        $ids                = $cat->child_node_and_self_list();

		$query 				= DB::table('goods as g')
								->leftjoin('goods_attr as ga','ga.goods_id','=','g.id');

		if(count($ids)== 1){

			$query 			= $query->where('g.cat_id',$this->cat_id);
		}
		else{

			$query 			= $query->whereIn('g.cat_id',$ids);
		}

		//价格区间
		if($this->min && $this->max){

			$min 			= intval($this->min);
			$max 			= intval($this->max);

			if($min > 0 && $max > 0 && $max >= $min){

					$query 	= $query->where('g.shop_price','>=',$min)
									->where('g.shop_price','<=',$max);
			}
		}

		//查询品牌编号
		$brand_id 			= intval($this->brand_id);
		if($brand_id > 0){

				$query 		= $query->where('g.brand_id',$brand_id);
		}

		//查询属性
		if(count($this->attr) == 1){

			   $ids 		= $this->attr;
			   $goods_attr  = GoodsAttr::find($ids[0]);
			   $query 		= $query->where('ga.attr_value',$goods_attr->attr_value);
			
		}
		elseif(count($this->attr) > 1){

			   $ids 		= $this->attr;
			   $attr_values = GoodsAttr::getValueList($ids);
			   $query 		= $query->whereIn('ga.attr_value',$attr_values);
		}

		//查询商品信息
		$query 				= $query->select('g.*');
		$total 				= $query->groupBy('g.id')->get();

		return count($total);

	}

	/*
	|----------------------------------------------------------------------------
	|
	|	根据参数 输入商品结果 
	|
	|----------------------------------------------------------------------------
	*/ 
	public function  data(){


		if(empty($this->cat_id)){

			return false;
		}
		$cat 			= Category::find($this->cat_id);

		if(empty($cat)){

			return false;
		}

		//获取商品分类id以及所有子类id
        $ids                = $cat->child_node_and_self_list();


		$query 				= DB::table('goods as g')
								->leftjoin('goods_attr as ga','ga.goods_id','=','g.id');

		if(count($ids)== 1){

			$query 			= $query->where('g.cat_id',$this->cat_id);
		}
		else{

			$query 			= $query->whereIn('g.cat_id',$ids);
		}

		if($this->min && $this->max){

			$min 			= intval($this->min);
			$max 			= intval($this->max);

			if($min > 0 && $max > 0 && $max >= $min){

					$query 	= $query->where('g.shop_price','>=',$min)
									->where('g.shop_price','<=',$max);
			}
		}

		//查询品牌编号
		$brand_id 			= intval($this->brand_id);
		if($brand_id > 0){

				$query 		= $query->where('g.brand_id',$brand_id);
		}

		//查询属性
		if(count($this->attr) == 1){

			   $goods_attr_ids 		= $this->attr;
			   $goods_attr 			= GoodsAttr::find($goods_attr_ids[0]);
			   $query 				= $query->where('ga.attr_value',$goods_attr->attr_value);
			
		}
		elseif(count($this->attr) > 1){

			   $ids 				= $this->attr;
			   $attr_values 		= GoodsAttr::getValueList($ids);
			   $query 		= $query->whereIn('ga.attr_value',$attr_values);
		}

		//查询商品信息
		$query 				= $query->select('g.*');

		//获取分页数据信息
		$total 				= $this->total();
		$current_page 		= $this->page->get('current_page');
		$per_page 			= $this->page->get('per_page');
		$last_page 			= ceil($total / $per_page);

		if($current_page <= $last_page){

			$skip_num 		= ($current_page -1)* $per_page;
		}
		else{

			$skip_num 		= 0;
			$current_page 	= 1;
		}

		$query 				= $query->orderBy('g.'.$this->sort_name,$this->sort_value)
									->groupBy('g.id')
									->skip($skip_num)
									->take($per_page)
									->get();

		return $query;

	}


	/*
	|----------------------------------------------------------------------------
	|
	|	把结果转化成数组
	|
	|----------------------------------------------------------------------------
	*/
	public function toArray(){

		$data 				= $this->data();
		$row 				= [];

		foreach($data as $item){

			$goods 			= Goods::find($item->id);
			$gallerys 		= [];

			foreach($goods->gallery()->get() as $gallery){

				$gallerys[] = [

							'thumbOss'				=>$gallery->thumb(),
							'imgOss'				=>$gallery->img(),
							'originalOss'			=>$gallery->_original(),
				];
			}
			//返回数组
			$row[] 			= [

							'id'					=>$item->id,
							'goods_sn'				=>$item->goods_sn,
							'goods_name'			=>$item->goods_name,
							'brand_id'				=>$item->brand_id,
							'cat_id'				=>$item->cat_id,
							'url'					=>$goods->url(),
							'shop_price'			=>$item->shop_price,
							'market_price'			=>$item->market_price,
							'gallery'				=>$goods->gallery,
							'thumb'					=>$goods->thumb(),
							'short_goods_name'		=>str_limit($item->goods_name,25,'..'),
							'gallerys'				=>$gallerys,
 
			];
		}

		return $row;
	}


	/*
	|----------------------------------------------------------------------------
	|
	|	从缓存中获取数据记录
	|
	|----------------------------------------------------------------------------
	*/
	public function getGoodsList(){
		//获取缓存的key
		$cacheKey  	= $this->getCacheKey();
		if(Cache::has($cacheKey)){

			return Cache::get($cacheKey);
		}
		//从数据库中取数据 并放入缓存中
		if($value  = $this->toArray()){
			Cache::put($cacheKey,$value,3600);
			return Cache::get($cacheKey);
		}

		return false;
	}

	/*
	|----------------------------------------------------------------------------
	|
	|	分页信息
	|
	|----------------------------------------------------------------------------
	*/
	public function page(){

		$row 	= [

					'current_page'		=>$this->page->get('current_page'),
					'last_page'			=>$this->page->get('last_page'),
					'per_page'			=>$this->page->get('per_page'),
					'total'				=>$this->page->get('total')
		];

		return $row;
	}

	/*
    |-------------------------------------------------------------------------------
	|
	|   生成商品列表字符串信息
	|
	|-------------------------------------------------------------------------------
	*/
	public function goods_list(){

		$str 	= '';
		$data 	= $this->data();

		if(empty($data)){

			return $str;
		}

		foreach($data as $item){

			$model 		= Goods::find($item->id);

			//商品的缩略图
			if($model->thumb()){

				$thumb 						= $model->thumb();
			}
			else{

				$thumb 						= url('front/matrix/images/phpstore-def.png');
			}

			//获取商品缩略图
			$gallery_list  					= '';
			if($model->gallery()->get()){

				$gallery_list 				= '<div class="thumb-list">';

				foreach($model->gallery()->get() as $gallery){

					$gallery_list  		  .= '<img src="'.$gallery->thumb().'" class="goods-thumb-min">';

				}

				$gallery_list 			 .= '</div>';
			}

			$str 		.='<div class="item cat-item">'
            			 .'<div class="item-bb">'
                		 .'<div class="pic">'
                 		 .'<a href="'.url($model->url()).'">'
                 		 .'<img src="'.$thumb.'" alt="'.$item->goods_name.'" class="goods-thumb" />'  
                 		 .'</a>'
                		 .'</div>'
                		 .$gallery_list
                		 .'<p class="text">'
                		 .'<a href="'.url($model->url()).'">'
                		 .str_limit($item->goods_name,32,'...')
                		 .'</a>'
                		 .'</p>'
                    	 .'<p class="price">'.$item->shop_price.'</p>'
                		 .'<div class="cart-icon" data-goods_id="'.$model->id.'">'
                		 .'<i class="fa fa-shopping-cart"></i>'
                		 .'</div>'
                		 .'<div class="tag sale-tag"></div>'
            			 .'</div>'
            			 .'</div>';
		}

		return $str;
	}


	/*
    |-------------------------------------------------------------------------------
	|
	|   生成商品列表字符串信息
	|
	|-------------------------------------------------------------------------------
	*/
	public function goods_list_mobile(){

		$str 	= '<div class="row">';
		$data 	= $this->data();

		if(empty($data)){

			return $str;
		}

		foreach($data as $item){

			$model 		= Goods::find($item->id);
			//商品的缩略图
			if($model->thumb()){

				$thumb 						= $model->thumb();
			}
			else{

				$thumb 						= url('front/matrix/images/phpstore-def.png');
			}

			//获取商品缩略图
			$gallery_list  					= '';
			if($model->gallery()->get()){

				$gallery_list 				= '<div class="thumb-list">';

				foreach($model->gallery()->get() as $gallery){

					$gallery_list  		  .= '<img src="'.url($gallery->thumb).'" class="goods-thumb-min">';

				}

				$gallery_list 			 .= '</div>';
			}

			$str 		.= '<div class="col s6">'
  						  .'<div class="card">'
    					  .'<div class="card-image waves-effect waves-block waves-light">'
      				 	  .'<a href="'.url($model->url()).'">'
     					  .'<img src="'.$thumb.'" alt="'.$model->goods_name.'"  class="activator"/>'
     					  .'</a>'
    					  .'</div>'
    					  .'<div class="card-content">'
      					  .'<p><a href="'.$model->url().'">'.str_limit($model->goods_name,15,'..').'</a></p>'
      					  .'<p class="price">'.$model->shop_price.'</p>'
    					  .'</div>'
  						  .'</div>'
						  .'</div>';
		}

		   $str 	    .= '</div>';

		return $str;
	}

	

	/*
    |-------------------------------------------------------------------------------
	|
	|   输出相应的json信息
	|
	|-------------------------------------------------------------------------------
	*/
	public function render(){

		$row 						= [];
		$row['data']				= $this->toArray();
		$row['page']				= $this->page();
		$row['links'] 				= $this->page->links();
		$row['min'] 				= $this->min;
		$row['max'] 		    	= $this->max;
		$row['brand_id']			= $this->brand_id;
		$row['attr']				= $this->attr;
		$row['goods_list']			= $this->goods_list();
		$row['sort_name']			= $this->sort_name;
		$row['sort_value']			= $this->sort_value;
		$row['goods_list_mobile']	= $this->goods_list_mobile();

		return  json_encode($row,JSON_UNESCAPED_UNICODE);
	}

}