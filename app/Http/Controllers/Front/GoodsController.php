<?php

namespace App\Http\Controllers\Front;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Session;
use App\Models\Goods;
use App\Models\Category;
use App\Models\Brand;
use App\Models\CollectGoods;
use Phpstore\Base\Common;
use Phpstore\Front\CartCommon;
use App\Models\Cart;
use DB;
use Auth;
use Request;
use App\Models\Tag;


class GoodsController extends BaseController
{
    

    
    public $helper;
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
        parent::__construct();
        
        $this->helper       = new CartCommon();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 商品详情页面处理函数
    |
    |-------------------------------------------------------------------------------
    */
    public function index($id){
        

        $model                      = Goods::find($id);
        $common                     = new Common();

        if(empty($model)){

            return $this->view('404');
        }
        
        $view                       = $this->view('goods');
        $view->goods                = $model;
        $view->breadcrumb           = $this->get_breadcrumb($id);
        $view->breadcrumb_mobile    = $this->breadcrumb_mobile($model->goods_name,$model->url());
        $view->gallery              = $model->gallery()->get();
        $view->img                  = $model->gallery()->first();
        $view->brand                = $common->get_goods_brand($id);
        $view->relation_goods       = $common->get_relation_goods($id,2);
        $view->goods_attr           = $common->get_goods_attr($id); 
        $view->goods_url            = $common->build_goods_url($id);
        $view->body_id              = 'goods_html';
        $view->rank                 = $common->get_rank_info($id);
        $view->tag_list             = $this->get_tag_list();

        return $view;
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 处理商品自定义url链接
    |
    |-------------------------------------------------------------------------------
    */
    public function diy_url($diy_url){

        $row            = DB::table('goods')->where('diy_url',$diy_url)->first();

        if(empty($row)){

            return $this->view('404');
        }

        return $this->index($row->id);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取商品详情页面的面包屑导航链接
    |
    |-------------------------------------------------------------------------------
    */
    public function get_breadcrumb($id){

        $model                  = Goods::find($id);
        $str                    = $model->goods_name;
        $cat                    = Category::find($model->cat_id);
        $common                 = new Common();
        $cat_url                = $common->build_category_url($model->cat_id);


        $str        = '<ol class="breadcrumb">'
                      .'<li><a href="'.url('/').'">首页</a></li>'
                      .'<li><a href="'.$cat_url.'">'.$cat->cat_name.'</a></li>'
                      .'<li class="active">'.$str.'</li>'
                      .'</ol>';

        return $str;
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 处理 collect的ajax
    |
    |-------------------------------------------------------------------------------
    */
    public function collect(){

        if($this->is_mobile()){

            return $this->mobile_collect();
        }

        $info       = 'error';

        if(!$this->is_front()){

            return $this->toJSON(['info'=>$info]);
            exit;
        }

        $goods_id   = Request::input('goods_id');
        $goods_id   = intval($goods_id);

        $res        = CollectGoods::where('goods_id',$goods_id)->where('user_id',Auth::user()->id)->first();

        if(empty($res)){

              $model                = new CollectGoods();
              $model->goods_id      = $goods_id;
              $model->user_id       = Auth::user()->id;
              $model->add_time      = time();
              
              if($model->save()){

                  $info             = 'success';
                  return $this->toJSON(['info'=>$info]);
                  exit;
              }
        }
        else{

            if($res->delete()){

                $info              = 'cancel';
                return $this->toJSON(['info'=>$info]);
                exit;

            }
        }
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 处理 collect的ajax mobile
    |
    |-------------------------------------------------------------------------------
    */
    public function mobile_collect(){

        if(!Auth::check('user')){

            return $this->toJSON(['info'=>'nologin']);
        }

        $goods_id           = intval(request()->goods_id);
        $_token             = request()->_token;
        $goods              = Goods::find($goods_id);

        if(empty($goods)){

            return $this->toJSON(['info'=>'error']);
        }

        if($goods->is_collect()){

            $goods->collect()->where('user_id',Auth::user('user')->id)->delete();
        }
        else{

            $data           = [
                                    'user_id'   =>Auth::user('user')->id,
                                    'goods_id'  =>$goods_id,
                                    'add_time'  => time(),
            ];
            CollectGoods::create($data);
        }

        $str                = 'favorite_border';
        $number             = $goods->collect_number();
        if($goods->is_collect()){

            $str            = 'favorite';
        }   

         $data              = [
                                 'info'         =>'success',
                                 'str'          =>$str,
                                 'number'       =>$number,
         ];

        return $this->toJSON($data);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 立即加入购物车 ajax-buy
    |
    |-------------------------------------------------------------------------------
    */
    public function ajax_buy(){

        if(Auth::check('user')){

            $post           = request()->info;
            $post           = json_decode($post);
            
            $goods_id       = intval($post->goods_id);
            $goods_number   = intval($post->goods_number);
            $goods_attr     = $post->goods_attr;

            //$this->helper->buy($goods_id ,$goods_number,$goods_attr);
            $goods          = Goods::find($goods_id);

            if(empty($goods)){

                return false;
            }
            //加入购物车 或者更新购物车
            $goods->buy($goods_attr,$goods_number);

            $info           = trans('front.add to cart is success');
            $url            = url('cart');

            $str            = '<a href="'.url('cart').'" class="btn btn-info">'.trans('front.checkout').'</a>'
                            .'&nbsp;&nbsp;'
                            .'<a href="'.url('goods/'.$goods_id).'" class="btn btn-success">'
                            .trans('front.continue shop')
                            .'</a>';

            $tag            = 'ok';

            $cart_num       = Cart::number();

            return $this->toJSON(['info'=>$info,'url'=>$url,'tag'=>$tag,'str'=>$str,'cart_num'=>$cart_num]);
        }
       

            //未登录则提示
            $info       = trans('front.login_for_buy');
            $url        = '<a href="'.url('auth/login').'" class="buy-login-btn">'.trans('front.login').'</a>';
            $tag        = 'nologin';
            $row        = ['info'=>$info ,'url'=>$url,'tag'=>$tag];
            return $this->toJSON($row);        

    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 添加标签
    |
    |-------------------------------------------------------------------------------
    */
    public function ajax_tag(){

        if(!Auth::check('user')){

            $info       = trans('front.login_for_tag');
            $tag        = 'nologin';

            $row        = ['info'=>$info ,'tag'=>$tag];

            return $this->toJSON($row);
        }

        $tag_name       = Request::input('tag_name');
        $goods_id       = Request::input('goods_id');

        $rules          = ['tag_name'=>'required|unique:tag,tag_name'];
        $validator      = Validator::make(Request::all(),$rules);

        if($validator->fails()){

            $info       = trans('front.tag_name_is_empty_or_unique'); 
            $tag        = 'empty';

            $row        = ['info'=>$info ,'tag'=>$tag];

            return $this->toJSON($row);
        }

        //检测tag是否重复
        $res            = Tag::where('username',Auth::user('user')->username)
                             ->where('tag_name',$tag_name)
                             ->first();
        if($res){

            $info       = trans('front.tag_name_is_unique');
            $tag        = 'unique';

            $row        = ['info'=>$info ,'tag'=>$tag];

            return $this->toJSON($row);

        }

        //添加tag到数据库
        $tag                = new Tag();
        $tag->tag_name      = $tag_name;
        $tag->ip            = Request::getClientIp();
        $tag->add_time      = time();
        $tag->goods_id      = $goods_id;
        $tag->username      = Auth::user('user')->username;

        if($tag->save()){


            $tag_list   =  $this->get_tag_list();

            $row        = ['tag'=>'ok','tag_list'=>$tag_list];

            return $this->toJSON($row);
        }
    }
   

    /*
    |-------------------------------------------------------------------------------
    |
    | 获取所有标签列表
    |
    |-------------------------------------------------------------------------------
    */
    public function get_tag_list(){

        $str        = '';
        if(!Auth::check('user')){

            return false;
        }

        $row            = Tag::where('username',Auth::user('user')->username)->get();

        foreach($row as $item){

            $str       .= '<span class="tag-item">'
                         .'<a href="'.url('goods/'.$item->goods_id).'">'.$item->tag_name.'</a>'
                         .'</span>';
        }

        return $str;
    }



}