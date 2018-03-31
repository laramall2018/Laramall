<?php

namespace Phpstore\Repository;
use Cache;
use App\Models\Goods;
use App\Models\Config;
use Phpstore\ORM\CacheHelper;
use Phpstore\Crud\ImageLib;
use DB;
use LaraStore\Presenters\CategoryPresenter;
use LaraStore\Helpers\Cache\Common as CacheCommon;


trait CategoryRepository{

    /*
    |-------------------------------------------------------------------------------
    |
    | 获取分类的链接
    |
    |-------------------------------------------------------------------------------
    */
    public function url(){
        return ($this->diy_url)? url('category/'.$this->diy_url) : url('category/'.$this->id);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 上传分类图标
    |
    |-------------------------------------------------------------------------------
    */
    public function img(){

        $img                = new ImageLib();
        $img->put('file_name','cat_img');
        $img->put('dir','category');

        if($upload_img  = $img->upload_image()){

            //删除旧图片
            $this->delete_img();
            $this->cat_img  = $upload_img;
            $this->save();
        }
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 删除商品分类图标
    |
    |-------------------------------------------------------------------------------
    */
    public function delete_img(){

        if($this->cat_img){

            @unlink(public_path().'/'.$delete_img);
        }
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 设置结点的套嵌属性
    |
    |-------------------------------------------------------------------------------
    */
    public function node(){

        $parent_id          = request()->parent_id;
        $parent_id          = intval($parent_id);
        $self               = new static;
        $parent             = $self->find($parent_id);

        //如果存在父亲结点
        if(!empty($parent)){

            $this->makeChildOf($parent);
        }
        //不存在父亲结点 则设置为 root结点
        else{

            $this->makeRoot();
        }
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 套嵌关系异常
    | 1.让自己成为自己的父亲结点
    | 2.让自己的子类结点 成为自己的父亲结点
    |
    |-------------------------------------------------------------------------------
    */
    public function chain_error(){

        $arr                = [];
        $parent_id          = request()->parent_id;
        $parent_id          = intval($parent_id);   

        //获取结点的所有子类结点和自己组成的集合
        foreach($this->getDescendantsAndSelf() as $item){

            $arr[]      = $item->id;
        }

        if(in_array($parent_id , $arr)){

            return true;
        }

        return false;
    }




    /*
    |-------------------------------------------------------------------------------
    |
    | 返回结点的所有子类结点和自己组成的集合 用于查询商品分类下的所有商品列表
    |
    |-------------------------------------------------------------------------------
    */
    public function child_node_and_self_list(){

        $arr                = [];

        foreach($this->getDescendantsAndSelf() as $item){

            $arr[]          = $item->id;
        }
        return $arr;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 返回结点的所有子类结点和自己组成的集合 用于查询商品分类下的所有商品列表
    |
    |-------------------------------------------------------------------------------
    */
    public function  ids(){
        return $this->child_node_and_self_list();
    }




    /*
    |-------------------------------------------------------------------------------
    |
    | 生成缓存
    |
    |-------------------------------------------------------------------------------
    */
    public function cacheHelper(){

        return new CacheHelper();
    }

	/*
    |-------------------------------------------------------------------------------
    |
    | 获取分类列表
    |
    |-------------------------------------------------------------------------------
    */
    public static function getList(){

    	$key 			= 'category_list';
    	$self 			= new static;
    	if(Cache::has($key)){

    		return Cache::get($key);
    	}
        $value 		= $self->where('depth',0)->orderBy('id','asc')->get();
        Cache::put($key,$value,3600);
        return Cache::get($key);

    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 获取子类
    |
    |-------------------------------------------------------------------------------
    */
    public function  getChildren(){

    	$key 			=  'children_parent_id_is_'.$this->id;
    	if(Cache::has($key)){

    		return Cache::get($key);
    	}

    	if($value 		= $this->children()->get()){

    		Cache::put($key,$value,3600);
    		return Cache::get($key);
    	}

    	return false;
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 商品分页大小
    |
    |-------------------------------------------------------------------------------
    */
    public static function list_page_size(){

       return ($value = Config::getValue('list_page_size')) ? intval($value) : 20;
    }


   
    /*
    |-------------------------------------------------------------------------------
    |
    | 从缓存中获取商品价格的grade区间
    |
    |-------------------------------------------------------------------------------
    */
    public function price(){
        
        return $this->presenter()->cache()->price();
    }


    
    /*
    |-------------------------------------------------------------------------------
    |
    | 从缓存中 获取分类下的所有品牌
    |
    |-------------------------------------------------------------------------------
    */
    public function brand(){

        return $this->presenter()->cache()->brand();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取分类下的商品属性列表
    |
    |-------------------------------------------------------------------------------
    */
    public function getAttrFromDatabase(){

        $ids        = $this->child_node_and_self_list();

        $query      = DB::table('attribute as a')
                        ->leftjoin('goods_attr as ga','ga.attr_id','=','a.id')
                        ->leftjoin('goods as g','g.id','=','ga.goods_id');

        if(count($ids) == 1){

            $query  = $query->where('g.cat_id',$this->id);
        }
        else{

            $query  = $query->whereIn('g.cat_id',$ids);
        }

            $query  = $query->where('a.attr_type',0)
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

        $ids            = $this->child_node_and_self_list();

        if(count($ids) == 1){

            $query      = $query->where('g.cat_id',$this->id);
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
    | 从缓存中 获取分类下的所有品牌
    |
    |-------------------------------------------------------------------------------
    */
    public function attr(){

        $helper             =  $this->cacheHelper();
        $helper->key        = 'get_attr_list_from_cat_id_is_'.$this->id;
        $helper->time       = 3600;
        $helper->obj        = $this;
        $helper->funcName   = 'getAttrFromDatabase';
        return $helper->get();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 从缓存中 获取分类下的商品列表
    |
    |-------------------------------------------------------------------------------
    */
    public function goods_list(){

        return $this->presenter()->cache()->goods_list();
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 获取所有分类的递进式select option 从缓存中获取
    |
    |-------------------------------------------------------------------------------
    */
    public static function cat_select(){

        $self           = new static;
        $key            = 'get_all_category_select_option_list';
        $funcName       = 'getSelectFromDatabase';
        return $self->getCacheData(compact('key','funcName'));
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取所有分类的递进式select option
    |
    |-------------------------------------------------------------------------------
    */
    public static function getSelectFromDatabase(){


        $str        = '<option value="">请选择</option>';
        $self       = new static;
        $roots      = $self->roots()->get();

        foreach($roots as $root){

            $child_str  = $self->cat_child($root);

            $str    .= '<option value="'.$root->id.'">'.$root->cat_name.'</option>'
                    .$child_str;
        }

        return $str;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取子节点option
    |
    |-------------------------------------------------------------------------------
    */
    public static function cat_child($node){

        $str        = '';
        $self       = new static;
        foreach($node->children()->get() as $item){

            //获取间距
            $padding = '';
            for($i = 0; $i<$item->depth;$i++){

                $padding .= '&nbsp;&nbsp;&nbsp;&nbsp;';
            }

            $child_str = $self->cat_child($item);
            $str   .= '<option value="'.$item->id.'">'.$padding.$item->cat_name.'</option>'
                   .$child_str;
        }

        return $str;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取父亲结点
    |
    |-------------------------------------------------------------------------------
    */
    public function father(){

        if($this->isRoot()){

            return '';
        }

        return $this->parent()->first()->cat_name;
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 获取所有分类目录
    |
    |-------------------------------------------------------------------------------
    */
    public static function catalog(){

        $str                    = '<ul class="collection">';
        $self                   = new static;
        foreach($self->roots()->get() as $root){

             $child_str         = $self->catalog_children($root);

             $str              .= '<li class="collection-item"><a href="'.$root->url().'">'
                              
                               .$root->cat_name
                               .'</a>'
                               .$child_str
                               .'</li>';
        }

        $str                   .= '</ul>';

        return $str;
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 获取所有分类目录 子目录
    |
    |-------------------------------------------------------------------------------
    */
    public static function catalog_children($node){

        $str            = '<ul>';
        $self           = new static;
        foreach($node->children()->get() as $item){

                $child_str  = $self->catalog_children($item);

                $str    .= '<li><a href="'.$item->url().'">'
                        .$item->cat_name
                        .'</a>'
                        .$child_str
                        .'</li>';
        }

        $str           .= '</ul>';

        return $str;
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 设置 presenter
    |
    |-------------------------------------------------------------------------------
    */
    public function presenter(){
        return new CategoryPresenter($this);
    }

}