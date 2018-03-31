<?php

namespace LaraStore\Entity;
use App\Models\Category;
use App\Models\Goods;
use LaraStore\Cache\Helper;
use DB;
use Phpstore\Grid\Page;

class CategoryEntity extends CommonEntity{

	public $table;
	public $helper;
	public $model;
	public $modelClass;
	public $price;


	/*
    |-------------------------------------------------------------------------------
    |
    | 构造函数
    |
    |-------------------------------------------------------------------------------
    */
    public function __construct(){

    	parent::__construct();
    	
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 返回模型
    |
    |-------------------------------------------------------------------------------
    */
    public function getModelClass(){

    	 return Category::class;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取分类下的商品价格区间列表（从数据库）
    |
    |-------------------------------------------------------------------------------
    */
    public function getPriceFromDatabase($id){

    	//获取模型
    	$this->model 	= $this->find($id);
        if($this->model->grade  == 0){

            return false;
        }
        //获取该分类和其所有子分类组成的分类编号数组
        $ids                       = $this->model->child_node_and_self_list();

        if(count($ids) == 1){

            $max                    = Goods::where('cat_id',$this->id)->max('shop_price');
            $min                    = Goods::where('cat_id',$this->id)->min('shop_price');
        }
        else{

            $query                   = Goods::whereIn('cat_id',$ids);
            $max                     = $query->max('shop_price');
            $min                     = $query->min('shop_price');
        }

        //价格区间没等分的间距
        $skip_num                   = ceil(($max - $min)/$this->model->grade);

        $arr                        = [];

        if($min <= 0 || $max <= 0){
            return $arr;
        }

        for($i=0;$i<$this->model->grade;$i++){

            $start                  = intval($min);
            $end                    = intval($min + $skip_num);

            if($end >$max){

                $end                = intval($max);
            }

            $min                    = $min + $skip_num + 1;

            $arr[]                  = ['min'=>$start,'max'=>$end];
        }

        return $arr;

    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取分类下的商品价格区间列表 （从缓存中获取）
    |
    |-------------------------------------------------------------------------------
    */
    public function price($id){

    	$this->key 							= $this->table.'_get_price_list_by_id_is_'.$id;
    	$this->funcName 					= 'getPriceFromDatabase';
    	$this->id 							= $id;
    	return $this->getCache();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取分类下的所有商品的品牌
    |
    |-------------------------------------------------------------------------------
    */
    public function getBrandFromDatabase($id){

    	//先实例化模型
    	$this->model = $this->find($id);
        $query      = DB::table('brand as b')
                        ->leftjoin('goods as g','g.brand_id','=','b.id')
                        ->select('b.*');

        $ids        = $this->model->child_node_and_self_list();

        if(count($ids) == 1){

            $query  = $query->where('g.cat_id','=',$id);
        }
        else{

            $query  = $query->whereIn('g.cat_id',$ids);
        }

            //去掉重复的品牌
            $query  = $query->groupBy('b.id')->get();


        return $query;
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 获取分类下的商品品牌列表 （从缓存中获取）
    |
    |-------------------------------------------------------------------------------
    */
    public function brand($id){

    	$this->key 							= $this->table.'_get_brand_list_by_id_is_'.$id;
    	$this->funcName 					= 'getBrandFromDatabase';
    	$this->id 							= $id;
    	return $this->getCache();

    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取分类下的商品属性列表
    |
    |-------------------------------------------------------------------------------
    */
    public function getAttrFromDatabase($id){

    	//获取模型
    	$this->model 			= $this->find($id);
        $ids        			= $this->model->child_node_and_self_list();

        $query      			= DB::table('attribute as a')
                        			->leftjoin('goods_attr as ga','ga.attr_id','=','a.id')
                        			->leftjoin('goods as g','g.id','=','ga.goods_id');

        if(count($ids) == 1){

            $query  			= $query->where('g.cat_id',$this->model->id);
        }
        else{

            $query  			= $query->whereIn('g.cat_id',$ids);
        }

            $query  			= $query->where('a.attr_type',0)
                            			->select('a.id','a.attr_name')
                            			->groupBy('a.id')
                            			->get();

        if(empty($query)){

            return false;
        }

        $arr        = [];

        foreach($query as $item){

            $arr[]  = [
                            'id'            =>$item->id,
                            'attr_name'     =>$item->attr_name,
                            //获取属性名称下的 商品属性值
                            'attr_value'    =>$this->attr_value($item->id),
                      ];
        }

        return $arr;

    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取分类下指定属性名称的属性值列表
    |
    |-------------------------------------------------------------------------------
    */
    public function attr_value($attr_id){

        $query          = DB::table('goods_attr as ga')
                            ->leftjoin('goods as g','g.id','=','ga.goods_id');
        $ids            = $this->model->child_node_and_self_list();

        if(count($ids) == 1){

            $query      = $query->where('g.cat_id',$this->model->id);
        }
        else{

            $query      = $query->whereIn('g.cat_id',$ids);
        }

            $query      = $query->where('ga.attr_id',$attr_id)
                                ->select('ga.*')
                                ->orderBy('ga.sort_order','asc')
                                ->groupBy('ga.attr_value')
                                ->get();

            return $query;

    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 获取分类下的属性列表 （从缓存中获取）
    |
    |-------------------------------------------------------------------------------
    */
    public function attr($id){

    	$this->key 							= $this->table.'_get_attr_list_by_id_is_'.$id;
    	$this->funcName 					= 'getAttrFromDatabase';
    	$this->id 							= $id;
    	return $this->getCache();

    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 获取商品列表
    |
    |-------------------------------------------------------------------------------
    */
    public function getGoodsListFromDatabase($id){

    		//获取模型
    		$this->model 		= $this->find($id);
            $key                = request()->key;
            $value              = request()->value;
            $ids                = $this->model->child_node_and_self_list();

            if(count($ids) == 1){

                $query          = Goods::where('cat_id',$id);
            }
            else{

                $query          = Goods::whereIn('cat_id',$ids);
            }

            if($key && $value){

                if(in_array($key,['id','shop_price'])){

                    $query     = $query->orderBy($key,$value);
                }
            }

            //分页大小
            $page_size 		= Category::list_page_size();
            $query          = $query->orderBy('id','desc')->take($page_size)->get();

            return $query;

    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 获取分类下的属性列表 （从缓存中获取）
    |
    |-------------------------------------------------------------------------------
    */
    public function goods_list($id){

    	$this->key 							= $this->table.'_get_goods_list_by_id_is_'.$id;
    	$this->funcName 					= 'getGoodsListFromDatabase';
    	$this->id 							= $id;
    	return $this->getCache();

    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取json格式的商品数据
    |
    |-------------------------------------------------------------------------------
    */
    public function  goodsJson($id){

    	$arr 										= [];
    	foreach($this->goods_list($id) as $key=>$goods){

    		$arr[$key]['id']						= $goods->id;
    		$arr[$key]['goods_name']				= $goods->goods_name;
    		$arr[$key]['short_goods_name']			= str_limit($goods->goods_name,25,'..');
    		$arr[$key]['cat_id']					= $goods->cat_id;
    		$arr[$key]['brand_id']					= $goods->brand_id;
    		$arr[$key]['shop_price']				= $goods->shop_price;
    		$arr[$key]['thumb']						= $goods->thumb();
    		$arr[$key]['url']						= $goods->url();
    		$gallerys 								= [];

    		foreach($goods->gallery()->get() as $gallery){
    			$gallerys[]	= [

    							'thumbOss'			=>$gallery->thumb(),
    							'imgOss'			=>$gallery->img(),
    							'originalOss'		=>$gallery->_original(),
    			];
    		}

    		$arr[$key]['gallerys']					= $gallerys;
    	}
    	return $arr;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取商品的总记录
    |
    |-------------------------------------------------------------------------------
    */
    public function getTotal($id){

    		//获取模型
    		$this->model 		= $this->find($id);
            $ids                = $this->model->child_node_and_self_list();

            if(count($ids) == 1){

                $query          = Goods::where('cat_id',$id);
            }
            else{

                $query          = Goods::whereIn('cat_id',$ids);
            }
            return  ($value = $query->get())? count($value) : 0;
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 获取商品列表的分页
    |
    |-------------------------------------------------------------------------------
    */
    public function page($id){

    	$page 					= new Page();
    	$total 					= intval($this->getTotal($id));
    	$per_page 				= Category::list_page_size();
    	$current_page 			= 1;
    	$last_page      		= ceil($total/$per_page);
    	$page->init(compact('total','per_page','current_page','last_page'));

    	return  [
    				'current_page'	=> $page->get('current_page'),
    				'last_page'		=> $page->get('last_page'),
    				'per_page'		=> $page->get('per_page'),
    				'total'			=> $page->get('total'),
    				'number'		=> $page->number(),

    	];
    }

}