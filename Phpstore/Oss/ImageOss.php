<?php

namespace Phpstore\Oss;

use App\Models\Config;
use App\Models\Goods;
use Image;
use Storage;
use File;
use Validator;
use App\Models\GoodsGallery;

class ImageOss{

	public $thumb_width;
	public $thumb_height;
	public $img_width;
	public $img_height;
	public $file_name; 			//上传文件的name
    public $dir;                //项目目录
    public $upload;
    public $goods;              //商品模型
    public $img_desc;           //图片的描述


	/*
    |-------------------------------------------------------------------------------
    |
    | 构造函数
    |
    |-------------------------------------------------------------------------------
    */
    public function __construct(){

    	 $this->thumb_width 		= Config::get('thumb_width');
    	 $this->thumb_height 		= Config::get('thumb_height');
    	 $this->img_width 			= Config::get('img_width');
    	 $this->img_height 			= Config::get('img_height');
         //未设置目录 则默认目录为common
         $this->dir                 = 'common';
         $this->upload              = new StorageUpload();
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 设置值
    |
    |-------------------------------------------------------------------------------
    */
    public function put($key , $value){

        $this->$key = $value;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取值
    |
    |-------------------------------------------------------------------------------
    */
    public function get($key){

        if($this->$key){

            return $this->$key;
        }

        return '';
    }





    /*
    |-------------------------------------------------------------------------------
    |
    | 上传图片
    |
    |-------------------------------------------------------------------------------
    */
    public function upload_image(){

        //如果未上传图片
        if(!request()->hasFile($this->file_name)){

            return false;
        }

        //初始化$upload组件
        $this->upload->upload_field             = $this->file_name;
        //检测上传的文件是否是图片
        if(!$this->upload->image_type_check()){

            return false;
        }
        //获取上传图片资源
        $file                                   = request()->file($this->file_name);
        //获取上传图片的完整路径名称
        $file_name                              = $this->get_image_full_names($file);

        //上传原始图片
        $this->file                             = $file;
        $this->file_name                        = $file_name;
        $this->make_original();
        
        return $file_name;
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |  创建目录
    |
    |-------------------------------------------------------------------------------
    */
    public function create_dir(){

        $dir     = 'images/'.$this->dir.'/'.date('Ym');
        Storage::makeDirectory($dir);
        return $dir;

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  给图片重新命名
    |
    |-------------------------------------------------------------------------------
    */
    public function create_file_name(){

        //修复uniqid重复bug
        return date('YmdHij').time().'_'.str_random(10);
    }



    
    /*
    |-------------------------------------------------------------------------------
    |
    |  处理上传图片的类型检测
    |
    |-------------------------------------------------------------------------------
    */
    public function goods_gallery_check(){

        $rules              = [];
        //循环写入规则
        foreach(request()->file('original_imgs') as $key=>$value){

            $rules['original_imgs.'.$key]  = 'image';
        }

        $validator      = Validator::make(request()->all(),$rules);

        //如果有非图片的 直接返回false
        return ($validator->fails())? false : true;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  返回验证规则
    |
    |-------------------------------------------------------------------------------
    */
    public function rules(Array $rules){

        if(request()->hasFile('original_imgs')){

            foreach(request()->file('original_imgs') as $key=>$value){

                $rules['original_imgs.'.$key]   = 'image';
            }
        }

        return $rules;
    }

    
    /*
    |-------------------------------------------------------------------------------
    |
    |  处理商品相册
    |
    |-------------------------------------------------------------------------------
    */
    public function goods_gallery(Goods $goods){

        //是否上传
        if(!request()->hasFile('original_imgs')){

            return false;
        }

        //检测是否有非法图片
        if(!$this->goods_gallery_check()){

            return false;
        }

        //循环处理图片
        foreach(request()->file('original_imgs') as $key=>$file){

            //遇到空的表单 则继续
            if(empty($file)){

                continue;
            }

            //获取图片文字描述
            $img_descs                 = request()->img_descs;
            
            //生成单个上传表单的相册信息
            $this->goods               = $goods;
            $this->img_desc            = $img_descs[$key];
            $this->file                = $file;
            $this->make_gallery();

        }

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  单独上传的单个图片和缩略图
    |
    |-------------------------------------------------------------------------------
    */
    public function make_gallery(){

        //数组空 直接返回false
        if(empty($this->file)){

            return false;
        }

        $file                       = $this->file;
        //获取文件的名称数组
        $row                        = $this->get_gallery_full_names($file);

        //生成原始图片
        $this->file                 = $file;
        $this->file_name            = $row['original_name'];
        $this->make_original();

        //生成缩略图
        $this->file                 = $file;
        $this->file_name            = $row['thumb_name'];
        $this->make_thumb();

        //生成商品详情页面图片
        $this->file                 = $file;
        $this->file_name            = $row['img_name'];
        $this->make_detail();

        //处理数据库数据
        $arr                        = [
                                        'thumb'     => $row['thumb_name'],
                                        'original'  => $row['original_name'],
                                        'img'       => $row['img_name'],
                                        'img_desc'  => $this->img_desc,
        ];

        $gallery                    = GoodsGallery::create($arr);
        //存入模型
        $this->goods->gallery()->save($gallery);

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  创建商品相册目录
    |
    |-------------------------------------------------------------------------------
    */
    public function create_goods_dir(){

        $date                          = date('Ym');
        $original_dir                  = 'images/goods/'.$date.'/original';
        $img_dir                       = 'images/goods/'.$date.'/img';
        $thumb_dir                     = 'images/goods/'.$date.'/thumb';

        //oss上创建
        Storage::makeDirectory($original_dir);
        Storage::makeDirectory($img_dir);
        Storage::makeDirectory($thumb_dir);

        //本地创建目录
        Storage::disk('local')->makeDirectory($original_dir);
        Storage::disk('local')->makeDirectory($img_dir);
        Storage::disk('local')->makeDirectory($thumb_dir);
        
        return [

                    'original_dir'      => $original_dir,
                    'img_dir'           => $img_dir,
                    'thumb_dir'         => $thumb_dir,
        ];
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  返回文件的 基础名称 缩略图名称 原始图片名称完整路径
    |
    |-------------------------------------------------------------------------------
    */
    public function get_gallery_full_names($file){

        //文件扩展名
        $ext                        = $file->getClientOriginalExtension();
        //获取文件名称
        $file_name                  = $this->create_file_name();

        //原图文件名称
        $original_name              = $file_name.'-original.'.$ext;
        //缩略图文件名称
        $thumb_name                 = $file_name.'-thumb.'.$ext;
        //商品详情页面图片
        $img_name                   = $file_name.'-img.'.$ext;
        //创建原图 详情图 商品缩略图目录
        $dirs                       = $this->create_goods_dir();

        return [

                    'original_name'     => $dirs['original_dir'].'/'.$original_name,
                    'thumb_name'        => $dirs['thumb_dir'].'/'.$thumb_name,
                    'img_name'          => $dirs['img_dir'].'/'.$img_name,
        ];
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  返回图片文件的 完整路径名称
    |
    |-------------------------------------------------------------------------------
    */
    public function get_image_full_names($file){

        //获取文件的扩展名称
        $ext                                    = $file->getClientOriginalExtension();
        //获取文件目录
        $dir                                    = $this->create_dir();
        //创建文件名称
        $base_name                              = $this->create_file_name();
        //文件完整的名称
        $upload_full_name                       = $dir.'/'.$base_name.'.'.$ext;

        return $upload_full_name;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  重新生成商品图片
    |
    |-------------------------------------------------------------------------------
    */
    public function create_new_goods_image($id){

            $model                          = GoodsGallery::find($id);
            if(empty($model)){

                return false;
            }

            //缩略图完整文件名
            $thumb                          = $model->thumb;
            //商品详情页面图片完整文件名
            $img                            = $model->img;
            //获取原始上传图片
            $original                       = $model->__original();

            //获取原图文件资源链接
            $file                           = storage_path($original);

            //生成缩略图
            $this->file                     = $file;
            $this->file_name                = $thumb;
            $this->make_thumb();

            //生成商品详情页面图片
            $this->file                    = $file;
            $this->file_name               = $img;
            $this->make_detail();
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |  重新生成商品缩略图
    |
    |-------------------------------------------------------------------------------
    */
    public function make_thumb(){

        $this->upload->file             = $this->file;
        $this->upload->width            = $this->thumb_width;
        $this->upload->height           = $this->thumb_height;
        $this->upload->file_name        = $this->file_name;
        //上传缩略图
        $this->upload->resize();
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  重新生成商品详情页面图片
    |
    |-------------------------------------------------------------------------------
    */
    public function make_detail(){

        $this->upload->file             = $this->file;
        $this->upload->width            = $this->img_width;
        $this->upload->height           = $this->img_height;
        $this->upload->file_name        = $this->file_name;
        //上传缩略图
        $this->upload->resize();
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  生成原始图片
    |
    |-------------------------------------------------------------------------------
    */
    public function make_original(){

        $this->upload->file             = $this->file;
        $this->upload->file_name        = $this->file_name;
        $this->upload->storage_move();
    }



}