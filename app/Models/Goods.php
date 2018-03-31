<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Session;
use Phpstore\Repository\GoodsRepository;
use LaraStore\Cache\CacheCommon;
use LaraStore\Models\GoodsImage;
use LaraStore\Models\PriceFormat;
use LaraStore\Cache\GoodsCache;
use LaraStore\Presenters\GoodsPresenter;


class Goods extends Model{

	use GoodsRepository,CacheCommon;
	protected $table = 'goods';


    //定义fillable数组
    protected $fillable = [

                            'goods_name',    //商品名称
                            'goods_sn',      //商品货号
                            'cat_id',        //商品分类
                            'brand_id',      //商品品牌
                            'goods_number',  //商品库存
                            'market_price',  //市场价格
                            'shop_price',    //销售价格
                            'promote_price', //促销价格
                            'give_integral', //消费积分
                            'diy_url',       //自定义导航栏
                            'goods_desc',    //商品详细描述
                            'goods_weight',  //商品重量
                            'warn_number',   //警告库存
                            'is_new',        //新品
                            'is_hot',        //热卖
                            'is_best',       //精品
                            'keywords',      //关键词
                            'goods_brief',   //简单描述
                            'seller_note',   //供货商备注
                            'sort_order',    //排序
    ];

    protected $appends        = ['thumbOss'];


   /*
   |-------------------------------------------------------------------------------
   |
   | 获取商品图片链接地址
   |
   |-------------------------------------------------------------------------------
   */
   public function image(){

      return (new GoodsImage($this));
   }

   /*
   |-------------------------------------------------------------------------------
   |
   | 格式化价格
   |
   |-------------------------------------------------------------------------------
   */
   public function format(){

      return (new PriceFormat($this));
   }

   /*
   |-------------------------------------------------------------------------------
   |
   | 从缓存中获取数据
   |
   |-------------------------------------------------------------------------------
   */
   public function cache(){
      return (new GoodsCache($this));
   }


	/*
    |-------------------------------------------------------------------------------
    |
    | 一对多的关系 获取商品图片信息
    |
    |-------------------------------------------------------------------------------
    */
    public function gallery(){

    	//第一个编号为关联模型对应的编号 第二个为本模型对应的编号
    	return $this->hasMany('App\Models\GoodsGallery','goods_id','id');
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 一对多的关系 获取商品规格的值
    |
    |-------------------------------------------------------------------------------
    */
    public function field(){

        return $this->hasMany(GoodsField::class,'goods_id','id');
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 一对多的关系 获取关联商品信息
    |
    |-------------------------------------------------------------------------------
    */
    public function goods_relation(){

       return $this->hasMany(GoodsRelation::class,'goods_id','id');
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 一对多的关系 获取关联新闻信息
    |
    |-------------------------------------------------------------------------------
    */
    public function goods_article(){

        return $this->hasMany(GoodsArticle::class,'goods_id','id');
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 添加商品相册操作
    | 通过关联关系存储相册数据到相册表并和商品做关联
    |
    |-------------------------------------------------------------------------------
    */
    public function addGallery(GoodsGallery $gallery){

        return $this->gallery()->save($gallery);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 一对多的关系 获取商品属性列表
    |
    |-------------------------------------------------------------------------------
    */
    public function attr(){

        return $this->hasMany(GoodsAttr::class,'goods_id','id');
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 一对多的关系 获取商品货品信息
    |
    |-------------------------------------------------------------------------------
    */
    public function product(){

        //第一个编号为关联模型对应的编号 第二个为本模型对应的编号
        return $this->hasMany(Product::class,'goods_id','id');
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 一对多的关系 一个品牌有多个商品 一个商品只能属于某个品牌
    |
    |-------------------------------------------------------------------------------
    */
    public function brand(){

        // 第一个编号 为本模型对应的编号 第二个为关联的模型对应的编号
        return $this->belongsTo(Brand::class,'brand_id','id');
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 一对多的关系 一个分类有多个商品 一个商品只能属于某个具体分类
    |
    |-------------------------------------------------------------------------------
    */
    public function category(){

        // 第一个编号 为本模型对应的编号 第二个为关联的模型对应的编号
        return $this->belongsTo(Category::class,'cat_id','id');
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 一对多的关系 一个商品会有多个收藏记录
    |
    |-------------------------------------------------------------------------------
    */
    public function collect(){

      return $this->hasMany(CollectGoods::class,'goods_id','id');
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 一对多的关系 一个商品会有多个评价记录
    |
    |-------------------------------------------------------------------------------
    */
    public function comment(){

        return $this->hasMany(Message::class,'id_value','id');
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 统计当前商品被收藏的次数
    |
    |-------------------------------------------------------------------------------
    */
    public function collect_number(){

        return count($this->collect()->get());
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 判断当前登录用户是否收藏了本商品
    |
    |-------------------------------------------------------------------------------
    */
    public function is_collect(){

       if(!Auth::check('user')){

            return false;
       }

       if($this->collect()->where('user_id',Auth::user('user')->id)->first()){

          return true;
       }

          return false;

    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 处理促销日期
    |
    |-------------------------------------------------------------------------------
    */
    public function promote_date(){
        
            $this->promote_start_date  = strtotime(request()->promote_start_date);
            $this->promote_end_date    = strtotime(request()->promote_end_date);
            $this->save();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  一对多的关系 一个商品 在购物车中会出现多次
    |
    |-------------------------------------------------------------------------------
    */
    public function cart(){

        return $this->hasMany(Cart::class,'goods_id','id');
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 后台 获取商品的所有属性
    |
    |-------------------------------------------------------------------------------
    */
    public function admin_attr(){

        $str        = '';

        foreach($this->attr()->get() as $item){

            $str   .= '<div class="form-group">'
                     .'<label class="col-md-3 control-label">'.$item->attribute->attr_name.'</label>'
                     .'<div class="col-md-2">'
                     .'<input type="text" class="form-control" name="attr_values[]" value="'.$item->attr_value.'">'
                     .'</div>'
                     .'<label class="col-md-1 control-label">属性价格</label>'
                     .'<div class="col-md-2">'
                     .'<input type="text" class="form-control" name="attr_prices[]" value="'.$item->attr_price.'" >'
                     .'</div>'
                     .'<div class="col-md-2">'
                     .'<span class="btn btn-success add-attr-btn" data-attr_id="'
                     .$item->attr_id
                     .'"  data-attr_name="'
                     .$item->attribute->attr_name
                     .'">'
                     .'<i class="fa fa-plus"></i>添加'
                     .'</span>'
                     .'<span class="btn btn-default del-attr-btn del-attr-btn-ajax" data-goods_attr_id="'.$item->id.'">'
                     .'<i class="fa fa-times"></i>删除'
                     .'</span>'
                     .'</div>'
                     .'<input type="hidden" name="attr_ids[]" value="'.$item->attr_id.'">'
                     .'<input type="hidden" name="goods_attr_ids[]" value="'.$item->id.'">'
                     .'</div>';
        }

        return $str;
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 多对多 获取商品属性名称
    |
    |-------------------------------------------------------------------------------
    */
    public function attribute(){

        return $this->belongsToMany(Attribute::class,'goods_attr','goods_id','attr_id')->groupBy('attr_id');
                    
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取商品的属性组数据
    |
    |-------------------------------------------------------------------------------
    */
    public function attr_list(){

        $arr        = [];
        foreach($this->attribute as $attribute){

            $arr[]  = [
                            'attr_id'           =>$attribute->id,
                            'attr_name'         =>$attribute->attr_name,
                            'attr_value'        =>$attribute->attr()->where('goods_id',$this->id)->get(),
            ];
        }

        return $arr;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  加入商品到购物车 或者更新购物车
    |
    |-------------------------------------------------------------------------------
    */
    public function buy($goods_attr ,$goods_number){

        if(!Auth::check('user')){

            return false;
        }

        //通过一对多的关系 查找购物车中是否存在本模型记录
        $query                          = $this->cart()->where('user_id',Auth::user('user')->id);
        //如果待查找的属性不为空
        if(!empty($goods_attr)){

             $query                     = $query->where('goods_attr',$goods_attr);
        }

        $cart                           = $query->first();




        //更新购物车
        if($cart){

            
              $old_goods_number         = intval($cart->goods_number);
              $goods_number             = intval($goods_number);
              //新的商品数量
              $new_goods_number         = $old_goods_number  + $goods_number;
              //商品的库存
              $model_goods_number       = intval($this->goods_number);
             //检测商品库存是否够
             if($new_goods_number < $model_goods_number){

                  $cart->goods_number   = $new_goods_number;
                  $cart->is_checked     = 1;
                  $cart->save();
             }

             return $cart;
        }
        //全新添加商品到购物车中
        else{


             $data  = [

                         'goods_sn'         => $this->goods_sn,
                         'goods_name'       => $this->goods_name,
                         'market_price'     => $this->market_price,
                         'shop_price'       => $this->shop_price,
                         'goods_number'     => $goods_number,
                         'goods_attr'       => $goods_attr,
                         'user_id'          => Auth::user('user')->id,
                         'session_id'       => session()->getId(),
                         'thumb'            => $this->gallery()->first() ? $this->gallery()->first()->thumb :'',
                         'is_checked'       => 1,
                     ];

            //库存够
            if($goods_number < $this->goods_number){

                $cart   = Cart::create($data);
                $this->cart()->save($cart);
            }
        }


    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  通过商品名称搜索商品信息
    |
    |-------------------------------------------------------------------------------
    */
    public static function searchByName($goods_name){

        return Goods::where('goods_name','like','%'.$goods_name.'%')->get();


    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  设置辅佐函数 presenter
    |
    |-------------------------------------------------------------------------------
    */
    public function presenter(){
        return new GoodsPresenter($this);
    }



}