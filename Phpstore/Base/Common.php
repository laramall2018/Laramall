<?php namespace Phpstore\Base;

use HTML;
use Auth;
use Phpstore\Base\Sysinfo;
use DB;
use App\Models\Privi;
use App\Models\Role;
use App\Models\RolePrivi;
use App\Models\Goods;
use App\Models\Article;
use App\Models\ArticleCat;
use App\Models\Category;
use URL;
use App;
use Cache;
use Phpstore\Config\CommonHelper;
use Session;
use App\Models\Cart;
use App\Models\UserAddress;
use App\Models\Tag;
use App\Models\Sms;

class Common{

    public $help;



    /*
    |-------------------------------------------------------------------------
    |
    | 构造函数
    |
    |-------------------------------------------------------------------------
    */
    function __construct(){

        
        $this->help         = new CommonHelper();

    }


    /*
    |-------------------------------------------------------------------------
    |
    | 获取推荐商品信息
    |
    |-------------------------------------------------------------------------
    */
    public static function get_recommend_goods($tag ,$number){

        $tag_value  = ['new','hot','best','promote'];

        $tag_row    = [ 
                            'new'=>'is_new',
                            'hot'=>'is_hot',
                            'best'=>'is_best',
                            'promote'=>'is_promote'
                      ];

        if(!in_array($tag,$tag_value)){

            return false;
        }

        $row        = Goods::where($tag_row[$tag],1)
                             ->where('is_on_sale',1)
                             ->where('is_delete',0)
                             ->take($number)->get();

        foreach($row as $key=>$value){

            $row[$key]['gallery']           = self::get_goods_gallery($value['id']);
            $row[$key]['url']               = url('goods/'.$value['id']);
        }

        return $row;
    }


    /*
    |-------------------------------------------------------------------------
    |
    | 获取商品相册图片
    |
    |-------------------------------------------------------------------------
    */
    public static function get_goods_gallery($id){

        $row            = DB::table('goods_gallery')->where('goods_id',$id)->first();

        if($row){

            return $row;
        }

        return false;
    }

    /*
    |-------------------------------------------------------------------------
    |
    | 输出版权信息
    |
    |-------------------------------------------------------------------------
    */
    public static function copyright(){

        $str = '<a href="http://www.prorigine.com" target="_blank">'
               .'<span class="org">PowerBy</span>'
               .'<span class="green">'.env('APPNAME').'</span>'
               .'<span class="white">'.env('APPNAME_VERSION').'</span>'
               .'</a>';
        return $str;
    }


    /*
    |-------------------------------------------------------------------------
    |
    | 移动版本
    |
    |-------------------------------------------------------------------------
    */
    public static function mobile_version(){

        return env('MOBILE_VERSION');
    }


    /*
    |-------------------------------------------------------------------------
    |
    | 输出描述信息
    |
    |-------------------------------------------------------------------------
    */
    public static function desc(){

        $str    = '<p>phpstore simple版本为phpstore-b2c极速版本。去繁化简，专注于购物本身的功能实现。'
                  .'提供高效/安全/快捷的购物体验。基于Laravel5.1(LTS)版，可以非常方便的做二次开发和功能扩展。</p>';
        return $str;

    }

    /*
    |-------------------------------------------------------------------------
    |
    | 获取配置文件信息
    |
    |-------------------------------------------------------------------------
    */
    public function get_config_value($code){

        $field_row        = $this->help->field();

        if(in_array($code,$field_row)){

            $row          = DB::table('sys_config')->where('code',$code)->first();

            if($row){

                return $row->value;
            }
        }

        return false;
    }


    /*
    |-------------------------------------------------------------------------
    |
    | 获取新闻分类名称
    |
    |-------------------------------------------------------------------------
    */
    public function get_article_cat_name($cat_id){

        $row            = DB::table('article_cat')->where('id',$cat_id)->first();

        if($row){

            return $row->cat_name;
        }

        return false;

    }

    /*
    |-------------------------------------------------------------------------
    |
    | 获取分类下的新闻
    |
    |-------------------------------------------------------------------------
    */
    public function get_article_list_by_cat_id($cat_id){

         $row           = Article::where('cat_id',$cat_id)
                                  ->take(10)
                                  ->get();

         foreach($row as $key=>$value){


              $row[$key]['url']         = url('article/'.$value->id);

              if($value->diy_url){

                  $row[$key]['url']     = url('article/'.$value->diy_url);    
              }
         }

         return $row;
    }


    /*
    |-------------------------------------------------------------------------
    |
    | 获取帮助标题一
    |
    |-------------------------------------------------------------------------
    */
    public function get_help_title_name($code){

        $arr               = ['help_1','help_2','help_3','help_4','help_5'];
        if(!in_array($code,$arr)){

            return false;
        }
        $value             = $this->get_config_value($code);

        if($value){

            return $this->get_article_cat_name($value);
        }

        return false;
        
    }


    /*
    |-------------------------------------------------------------------------
    |
    | 获取帮助列表
    |
    |-------------------------------------------------------------------------
    */
    public function get_help_list($code){

        $arr               = ['help_1','help_2','help_3','help_4','help_5'];
        if(!in_array($code,$arr)){

            return false;
        }
        $value             = $this->get_config_value($code);

        if($value){

            return $this->get_article_list_by_cat_id($value);
        }

        return false;
        
    }


    /*
    |-------------------------------------------------------------------------
    |
    | 获取新闻的详细信息
    |
    |-------------------------------------------------------------------------
    */
    public function get_article_info($id){

        $model              = Article::find($id);

        if(empty($model)){

            return false;
        }

        return $model;
    }


    /*
    |-------------------------------------------------------------------------
    |
    | 获取新闻详情页面的面包屑导航菜单
    |
    |-------------------------------------------------------------------------
    */
    public function get_breadcrumb($str){


        $str        = '<ol class="breadcrumb">'
                      .'<li><a href="'.url('/').'">首页</a></li>'
                      .'<li class="active">'.$str.'</li>'
                      .'</ol>';
        return $str;
    }

    /*
    |-------------------------------------------------------------------------
    |
    |  获取新闻分类下的新闻列表
    |
    |-------------------------------------------------------------------------
    */
    public function get_article_list($id){

        $row            = Article::where('cat_id',$id)->paginate(20);

        if(empty($row)){

            return false;
        }

        foreach($row as $key=>$value){

            $row[$key]['url']         = url('article/'.$value->id);

              if($value->diy_url){

                  $row[$key]['url']     = url('article/'.$value->diy_url);    
              }
        }

        return $row;
    }


    /*
    |-------------------------------------------------------------------------
    |
    |  通过图片的标签获取图片的信息
    |
    |-------------------------------------------------------------------------
    */
    public static function get_image_info_from_tag($tag){

        $row            = DB::table('image')->where('img_tag',$tag)->first();

        if(empty($row)){

            return false;
        }

        return $row;
    }

    /*
    |-------------------------------------------------------------------------
    |
    |  返回首页幻灯片图片信息
    |
    |-------------------------------------------------------------------------
    */
    public static function get_slider_info(){

        $row                = DB::table('slider')->get();

        return $row;
    }


    /**
    * 获得指定分类同级的所有分类以及该分类下的子分类
    *
    * @access  public
    * @param   integer     $cat_id     分类编号
    * @return  array
    */
    public function get_categories_tree($cat_id = 0)
    {
        
        //获取给定分类参数的父结点
        if ($cat_id > 0)
        {
           
           $row                     = Category::find($cat_id);

           if($row){

                $parent_id          = $row->parent_id;
           }

        }
        else
        {
               $parent_id = 0;
        }

        /*
          判断当前分类中全是是否是底级分类，
          如果是取出底级分类上级分类，
          如果不是取当前分类及其下的子分类
        */
        $num     = DB::table('category')
                     ->where('parent_id',$parent_id)
                     ->where('is_show',1)
                     ->count();


        if ($num || $parent_id == 0)
        {
                /* 获取当前分类及其子分类 */
                $res       =  Category::where('parent_id',$parent_id)
                                      ->where('is_show',1)
                                      ->orderBy('sort_order','desc')
                                      ->get();
                foreach ($res AS $row)
                {
                    if ($row->is_show == 1)
                    {
                        
                        $cat_arr[$row->id]['id']                = $row->id;
                        $cat_arr[$row->id]['cat_name']          = $row->cat_name;
                        $cat_arr[$row->id]['url']               = $this->build_category_url($row->id);

                        if ($row->id)
                        {
                            $cat_arr[$row->id]['child']         = $this->get_child_tree($row->id);
                        }
                    }
                }
        }
        if(isset($cat_arr))
        {
            return $cat_arr;
        }
    }


    /*
    |-------------------------------------------------------------------------
    |
    |  获取给定分类结点的所有子节点
    |
    |-------------------------------------------------------------------------
    */
    public function get_child_tree($tree_id = 0)
    {
        
        $three_arr = array();

        //$sql = 'SELECT count(*) FROM ' . $GLOBALS['ecs']->table('category') . " WHERE parent_id = '$tree_id' AND is_show = 1 ";
        //获取该分类结点的所有子结点总数
        $num            = DB::table('category')
                            ->where('parent_id',$tree_id)
                            ->where('is_show',1)
                            ->count();

        if ($num|| $tree_id == 0)
        {
            /*
            $child_sql = 'SELECT cat_id, cat_name, parent_id, is_show ' .
                'FROM ' . $GLOBALS['ecs']->table('category') .
                "WHERE parent_id = '$tree_id' AND is_show = 1 ORDER BY sort_order ASC, cat_id ASC";
            $res = $GLOBALS['db']->getAll($child_sql);
            */

            $res        = DB::table('category')
                            ->where('parent_id',$tree_id)
                            ->where('is_show',1)
                            ->orderBy('sort_order','desc')
                            ->orderBy('id','asc')
                            ->get();

        foreach ($res AS $row)
        {
            if ($row->is_show == 1)

               $three_arr[$row->id]['id']               = $row->id;
               $three_arr[$row->id]['cat_name']         = $row->cat_name;
               $three_arr[$row->id]['url']              = $this->build_category_url($row->id);

               if ($row->id)
                   {
                       $three_arr[$row->id]['child']    = $this->get_child_tree($row->id);

               }
            }
        }

        return $three_arr;
    }


    /*
    |-------------------------------------------------------------------------
    |
    |  生成分类的链接
    |
    |-------------------------------------------------------------------------
    */
    public function build_category_url($id){

        $model              = Category::find($id);

        if(empty($model)){

            return url('/');
        }

        if($model->diy_url){

            return url('category/'.$model->diy_url);
        }

        return url('category/'.$id);
    }


    /*
    |-------------------------------------------------------------------------
    |
    |  获取首页导航栏信息
    |
    |-------------------------------------------------------------------------
    */
    public function get_nav_info($position){

        $row            = DB::table('nav')
                            ->where('position',$position)
                            ->where('is_show',1)
                            ->orderBy('sort_order','desc')
                            ->take(10)
                            ->get();
        
        return $row;
    }


    /*
    |-------------------------------------------------------------------------
    |
    |  获取分类下的商品列表
    |
    |-------------------------------------------------------------------------
    */
    public  function get_goods_list($cat_id,$key,$value){ 


        $goodslib                   = new Goodslib();
        $cat_id_array               = $goodslib->get_cat_array($cat_id);

        //获取分类页商品个数设置
        $num                        = $this->get_page_list_size();

        if(count($cat_id_array) == 1){


                $row                = Goods::where('cat_id',$cat_id);
        }else{

                $row                = Goods::whereIn('cat_id',$cat_id_array);
                                       
        }

        if($key && $value){

                if(in_array($key,['id','shop_price'])){

                    if(in_array($value,['desc','asc'])){

                        $row        = $row->orderBy($key,$value);
                    }
                }
        }
        else{

             $row                   = $row->orderBy('id','desc');
        }

             $row                   = $row->paginate($num);
             $arr                   = [];

        foreach($row as $key=>$value){

           
            $row[$key]['gallery']           = self::get_goods_gallery($value->id);
            $row[$key]['gallery_list']      = DB::table('goods_gallery')
                                                ->where('goods_id',$value->id)
                                                ->get();
            $row[$key]['url']               = $this->build_goods_url($value->id);
        }

        return $row;
    }

    /*
    |-------------------------------------------------------------------------
    |
    |  生成商品的url
    |
    |-------------------------------------------------------------------------
    */
    public function build_goods_url($goods_id){

         $goods             = Goods::find($goods_id);

         if($goods){

            return $goods->url();
         }

         return '';
    }

    /*
    |-------------------------------------------------------------------------
    |
    |  获取分类页商品个数
    |
    |-------------------------------------------------------------------------
    */
    public function get_page_list_size(){

        $num            = 20;

        $value          = intval($this->get_config_value('list_page_size'));

        if($value > 0){

            return $value;
        }

        return $num;
    }


    /*
    |-------------------------------------------------------------------------
    |
    |  获取分类广告
    |
    |-------------------------------------------------------------------------
    */
    public function get_cat_ad($cat_id){

         $row           = DB::table('cat_ad')->where('cat_id',$cat_id)->first();

         return $row;
    }


    /*
    |-------------------------------------------------------------------------
    |
    |  获取商品相册列表
    |
    |-------------------------------------------------------------------------
    */
    public function get_goods_gallery_list($id){

        $row            = DB::table('goods_gallery')
                            ->where('goods_id',$id)
                            ->get();
        return $row;
    }

    /*
    |-------------------------------------------------------------------------
    |
    |  获取商品品牌信息
    |
    |-------------------------------------------------------------------------
    */
    public function get_goods_brand($goods_id){

        $row            = DB::table('brand')
                        ->leftjoin('goods', 'brand.id', '=', 'goods.brand_id')
                        ->where('goods.id','=',$goods_id)
                        ->select('brand.brand_name')
                        ->first();
        return $row;

    }

    /*
    |-------------------------------------------------------------------------
    |
    |  获取关联商品链接
    |
    |-------------------------------------------------------------------------
    */
    public function get_relation_goods($goods_id,$num){

         $row           = DB::table('goods')
                            ->leftjoin('goods_relation','goods.id','=','goods_relation.relation_goods_id')
                            ->where('goods_relation.goods_id','=',$goods_id)
                            ->select('goods.id','goods.goods_name','goods.shop_price','goods.diy_url')
                            ->take($num)
                            ->get();
         $arr           = [];

         foreach($row as $key=>$value){

             $arr[$key]['id']                = $value->id;
             $arr[$key]['goods_name']        = $value->goods_name;
             $arr[$key]['shop_price']        = $value->shop_price;
             $arr[$key]['gallery']           = self::get_goods_gallery($value->id);
             $arr[$key]['url']               = $this->build_goods_url($value->id);      
         }

         return $arr;
    }


    /*
    |-------------------------------------------------------------------------
    |
    |  获取商品的单选属性列表
    |  三表联查
    |  + ps_goods       id
    |  + ps_attribute   attr_id  attr_name
    |  + ps_goods_attr  goods_id   attr_value attr_price
    |
    |-------------------------------------------------------------------------
    */
    public function get_goods_attr($id){

        $res             = DB::table('goods_attr')
                             ->leftjoin('attribute','attribute.id','=','goods_attr.attr_id')
                             ->leftjoin('goods','goods_attr.goods_id','=','goods.id')
                             ->where('goods_attr.goods_id','=',$id)
                             ->select('attribute.attr_name','goods_attr.attr_id')
                             ->groupBy('goods_attr.attr_id')
                             ->orderBy('attribute.sort_order','asc')
                             ->get();
        
        $row             = [];

        foreach($res as $key=>$value){

                $row[$key]['attr_id']                   = $value->attr_id;
                $row[$key]['attr_name']                 = $value->attr_name;
                $row[$key]['attr_value']                = $this->get_attr_value($value->attr_id ,$id);

        }

        return $row;

    }

    /*
    |-------------------------------------------------------------------------
    |
    |  获取指定商品 指定属性的属性值
    |
    |-------------------------------------------------------------------------
    */
    public function get_attr_value($attr_id , $goods_id){

         $res           = DB::table('goods_attr')
                            ->where('attr_id',$attr_id)
                            ->where('goods_id',$goods_id)
                            ->get();

        return $res;
    }

    /*
    |-------------------------------------------------------------------------
    |
    |  获取购物车商品数量
    |
    |-------------------------------------------------------------------------
    */
    public function get_cart_number(){

        if(!Auth::check()){

            return 0;
        }

        $res            = DB::table('cart')
                            ->where('user_id',Auth::user()->id)
                            ->sum('goods_number');
        return $res;
    }

    /*
    |-------------------------------------------------------------------------
    |
    |  获取搜索购物车中的产品列表
    |
    |-------------------------------------------------------------------------
    */
    public function get_search_goods_list($keywords){

        if(empty($keywords)){

            $row            = Goods::paginate(10);
        }
        else{

            $row            = Goods::where('goods_name','like','%'.$keywords.'%')
                                    ->orWhere('goods_sn','like','%'.$keywords.'%')
                                    ->paginate(10);
        }


        foreach($row as $key=>$value){

           
            $row[$key]['gallery']           = self::get_goods_gallery($value->id);
            $row[$key]['url']               = $this->build_goods_url($value->id);
        }


        return $row;
    }


    /*
    |-------------------------------------------------------------------------
    |
    |  获取模板配置文件中的值
    |
    |-------------------------------------------------------------------------
    */
    public  function get_template_config($code){

        $row            = DB::table('template_config')->where('code',$code)->first();

        if($row){

            return intval($row->value);
        }

        return false;
    }


    /*
    |-------------------------------------------------------------------------
    |
    |  获取会员等级价格
    |
    |-------------------------------------------------------------------------
    */
    public function get_rank_info($id){

        //先检测用户是否登录

        if(!Auth::check('user')){

            return false;
        }

        $model                  = Goods::find($id);

        if(empty($model)){

            return false;
        }

        $row                    = DB::table('user_rank')
                                    ->leftjoin('users','users.rank_id','=','user_rank.id')
                                    ->select('user_rank.*')
                                    ->where('users.id','=',Auth::user('usrs')->id)
                                    ->first();

        if($row){


            $arr                = [];
            $arr['discount']    = $row->discount;
            $arr['rank_name']   = $row->rank_name;
            $arr['rank_pic']    = $row->rank_pic;
            $arr['rank_price']  = ($model->shop_price * $row->discount)/100;

            return $arr;

        }

        return false;
    }

    /*
    |-------------------------------------------------------------------------
    |
    |  获取模板配置文件中的值
    |
    |-------------------------------------------------------------------------
    */
    public  function get_template_config_string($code){

        $row            = DB::table('template_config')->where('code',$code)->first();

        if($row){

            return $row->value;
        }

        return false;
    }


    /*
    |-------------------------------------------------------------------------
    |
    | 获取用户的所有收货地址
    |
    |-------------------------------------------------------------------------
    */
    public function get_user_address_list(){

        if(!Auth::check('user')){

            return false;
        }

        $data                               = UserAddress::where('user_id',Auth::user('user')->id)->get();

        if(empty($data)){

            return false;
        }

        foreach($data as $key=>$value){

            $country                        = $this->get_region_name($value['country']);
            $province                       = $this->get_region_name($value['province']);
            $city                           = $this->get_region_name($value['city']);
            $district                       = $this->get_region_name($value['district']);

            $value['address_str']           = $country.$province.$city.$district.$value['address'];  
        }

        return $data; 
    }


    /*
    |-------------------------------------------------------------------------
    |
    | 获取地区名称
    |
    |-------------------------------------------------------------------------
    */
    public function get_region_name($region_id){

        $row            = DB::table('region')->where('region_id',$region_id)->first();

        if(empty($row)){

            return '';
        }

        return $row->region_name;
    }

    /*
    |-------------------------------------------------------------------------
    |
    | 获取错误信息
    |
    |-------------------------------------------------------------------------
    */
    public function get_validator_message($validator){

        $str        = '';
        $messages   = $validator->messages();

        foreach($messages->all() as $message){

            $str    .= '<div class="alert alert-danger"><i class="fa fa-times"></i>'.$message.'</div>';
        }

        return $str;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 生成前台模板需要的提示信息
    |
    |-------------------------------------------------------------------------------
    */
    public function get_message_info($info,$i,$cls){

        $str            = '<div class="alert '.$cls.'">'
                          .$i
                          .$info
                          .'</div>';
        return $str;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取用户添加的所有标签
    |
    |-------------------------------------------------------------------------------
    */
    public function get_user_tag_list($username){


        $row        = Tag::where('username',$username)->paginate(20);

        if(empty($row)){

            return false;
        }

        foreach($row as $value){

                $value['goods_name']        = $this->get_goods_name($value->goods_id);
                $value['add_time_str']      = date('Y-m-d',$value->add_time);
        }

        return $row;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取商品名称
    |
    |-------------------------------------------------------------------------------
    */
    public function get_goods_name($goods_id){

        $res        = DB::table('goods')->where('id',$goods_id)->first();

        if($res){

            return $res->goods_name;
        }

        return '';
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 获取用户的短消息列表
    |
    |-------------------------------------------------------------------------------
    */
    public function get_sms_list(){

        if(!Auth::check('user')){

            return false;
        }

        $res                            = Sms::where('user_id',Auth::user('user')->id)->paginate(10);

        if(empty($res)){

            return false;
        }

        foreach($res as $value){

            $value['admin']             = $this->get_admin_info($value->admin_id);    
        }



        return $res;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取管理员信息
    |
    |-------------------------------------------------------------------------------
    */
    public function get_admin_info($admin_id){

        $admin_id           = intval($admin_id);

        if($admin_id == 0){

            return false;
        }

        return DB::table('admins')->where('id',$admin_id)->first();
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 获取账号总金额
    |
    |-------------------------------------------------------------------------------
    */
    public function get_user_account_amount($username){

         $amount        = DB::table('users_account')
                            ->where('username',$username)
                            ->where('type',0)
                            ->where('pay_tag',1)
                            ->sum('amount');

         $amount2       = DB::table('users_account')
                            ->where('username',$username)
                            ->where('type',1)
                            ->where('pay_tag',1)
                            ->sum('amount');

         if($amount && $amount2){

            return $amount - $amount2;
         }


         return 0;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取配色方案列表
    |
    |-------------------------------------------------------------------------------
    */
    public function get_style_list(){

        $res            = DB::table('style')->orderBy('sort_order','asc')->get();
        $str            = '';

        if(empty($res)){

            return $str;
        }

        foreach($res as $item){

            $style_css_file     = url('front/matrix/'.$item->style_css_file);

            $str     .= '<div class="color-grid-item">'
                       .'<span data-style_css_file="'
                       .$style_css_file
                       .'" class="color-item-span" style="background:'.$item->style_value.'">'
                       .'<i class="fa fa-check"></i>'
                       .'</span>'
                       .'</div>';
        }

        return $str;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取新闻的帮助中心
    |
    |-------------------------------------------------------------------------------
    */
    public function get_help_article_list(){

        $key            = 'help_list';
        if(Cache::has($key)){

            return Cache::get($key);
        }

        $res            = ArticleCat::where('is_help',1)
                                    ->take(5)
                                    ->orderBy('sort_order','asc')
                                    ->get();
        Cache::put($key,$res,3600);
        return Cache::get($key);

    }



}