<?php namespace Phpstore\Crud;

use Input;
use Request;
use DB;
use Image;
use App\Models\GoodsGallery;
use Validator;

class ImageLib{


    protected $dir;
    protected $width;
    protected $height;
    protected $original;
    protected $thumb;
    protected $file_name; 




    /*
    |-------------------------------------------------------------------------------
    |
    | 构造函数
    |
    |-------------------------------------------------------------------------------
    */
    function __construct(){


        $this->thumb_width          = $this->get_config_value('thumb_width');
        $this->thumb_height         = $this->get_config_value('thumb_height');
        $this->img_width            = $this->get_config_value('img_width');
        $this->img_height           = $this->get_config_value('img_height');



    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 设置值
    |
    |-------------------------------------------------------------------------------
    */
    public function set_value($key , $value){

        $this->$key = $value;
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
    |  创建目录和创建文件名称
    |
    |-------------------------------------------------------------------------------
    */
    public function create_dir(){

        $dir            = $this->dir;
        $date           = date('Ym');
        $img_dir        = public_path().'/images/'.$dir.'/'.$date;

        //目录不存在 则创建
        if(!is_dir(public_path().'/images/'.$dir)){

                @mkdir(public_path().'/images/'.$dir , 0777);
        }

        //目录不存在 则创建
        if(!is_dir($img_dir)){

                @mkdir($img_dir , 0777);
        }

         @chmod(public_path().'/images/'.$dir,0777);
         @chmod($img_dir,0777);

         //返回图片最终存放的目录位置
         return 'images/'.$dir.'/'.$date;
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  创建和上传图片
    |
    |-------------------------------------------------------------------------------
    */
    public function upload_image(){

        //如果上传了图片

        if(Input::hasFile($this->file_name)){

            $rules         = [$this->file_name =>'image'];

            $validator     = Validator::make(request()->all(),$rules);

            if($validator->fails()){

                return false;
            }

            $file           = Input::file($this->file_name);
            $ext            = $file->getClientOriginalExtension();
            $filename       = $file->getClientOriginalName();

            $img_dir        = $this->create_dir();
            $img_name       = $this->create_file_name();

            //移动图片文件到最终图片存放目录
            $file->move(public_path().'/'.$img_dir , $img_name.'.'.$ext);

            $this->original         = $img_dir.'/'.$img_name.'.'.$ext;
            return $this->original;

        }

        return false;
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  创建缩略图
    |
    |-------------------------------------------------------------------------------
    */
    public function make_thumb(){

         if($this->upload_image()){

                $upload_image           = public_path().'/'.$this->original;
                $row                   = $this->get_original_info();

                $upload_dir            = $row['upload_dir'];
                $upload_name           = $row['upload_name'];
                $ext                   = $row['ext'];

                $thumb_name            = 'thumb-'.$upload_name;

                //生成缩略图
                $img                   = Image::make($upload_image)
                                                ->resize($this->width,$this->height, function ($constraint) {
                                                                                  $constraint->aspectRatio();});

                $img->save(public_path().'/'.$upload_dir.'/'.$thumb_name.'.'.$ext,100);

                $this->thumb           = $upload_dir.'/'.$thumb_name.'.'.$ext;

                return $upload_dir.'/'.$thumb_name.'.'.$ext;
         }

         return false;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  删除上传图片
    |
    |-------------------------------------------------------------------------------
    */
    public function delete_upload_image(){

        if($this->original){

            @unlink(public_path().'/'.$this->original);
        }
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  获取上传图片的真实路径和名称  扩展名
    |
    |-------------------------------------------------------------------------------
    */
    public function get_original_info(){

        $upload_image           = $this->original;

        $row                    = pathinfo($upload_image);

        $upload_dir             = $row['dirname'];
        $base_name              = $row['basename'];
        $ext                    = $row['extension'];

        $arr                    = explode('.',$base_name);
        $upload_name            = $arr[0];


        return ['upload_dir'=>$upload_dir , 'upload_name'=>$upload_name,'ext'=>$ext];

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
        return md5(uniqid(md5(microtime(true)),true));
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  创建商品缩略图目录
    |
    |-------------------------------------------------------------------------------
    */
    public function create_goods_dir(){

        $img_dir          = public_path().'/images';
        $date             = date('Ym');
        $date_dir         = public_path().'/images/'.$date;

        $original_dir     = $date_dir.'/original';
        $thumb_dir        = $date_dir.'/thumb';
        $detail_dir       = $date_dir.'/detail';


       $this->create_base_dir($img_dir);
       $this->create_base_dir($date_dir);
       $this->create_base_dir($original_dir);
       $this->create_base_dir($thumb_dir);
       $this->create_base_dir($detail_dir);

       $row               = [

                                'original_dir'=>'images/'.$date.'/original',
                                'thumb_dir'=>'images/'.$date.'/thumb',
                                'detail_dir'=>'images/'.$date.'/detail',
                            ];
       return $row;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  创建目录
    |
    |-------------------------------------------------------------------------------
    */
    public function create_base_dir($dir){

        //目录不存在 则创建目录 并设置权限
        if(!is_dir($dir)){

           @mkdir($dir ,0777);
        }

        //如果目录存在 则设置目录权限
        @chmod($dir,0777);

        return $dir;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  处理上传商品相册
    |
    |-------------------------------------------------------------------------------
    */
    public function goods_gallery($goods){

        //如果上传了商品相册
        if(Request::hasFile('original_imgs')){

              $row              = $this->create_goods_dir();
              $files            = Request::file('original_imgs');

              //如果上传的文件中 有不是图片的 终止上传
              if(!$this->goods_gallery_check()){

                    return false;
              }

              //删除商品相册中的记录和图片信息
              //$this->delete_goods_gallery($id);
              foreach($files as $key=>$file){


                   if(empty($file)){

                      continue;
                   }
                  //获取扩展名
                  $ext            = $file->getClientOriginalExtension();
                  $original_dir   = $row['original_dir'];
                  $img_name       = $this->create_file_name();

                  $original       = $img_name.'-original';
                  //移动图片文件到最终图片存放目录
  	               $file->move(public_path().'/'.$original_dir , $original.'.'.$ext);

                   //生成缩略图
                   $thumb_width    = $this->thumb_width;
                   $thumb_height   = $this->thumb_height;
                   $img            = Image::make(public_path().'/'.$original_dir.'/'.$original.'.'.$ext)
                                       ->resize($thumb_width,$thumb_height, function ($constraint) { $constraint->aspectRatio();});

                   $thumb_dir      = $row['thumb_dir'];
                   $thumb_name     = $img_name.'-thumb';
                   //把商品缩略图保存到指定的位置
                   $img->save(public_path().'/'.$thumb_dir.'/'.$thumb_name.'.'.$ext,100);

                   //生成detail页面的图片
                   $img_width      = $this->img_width;
                   $img_height     = $this->img_height;
                   $img            = Image::make(public_path().'/'.$original_dir.'/'.$original.'.'.$ext)
                                       ->resize($img_width,$img_height, function ($constraint) { $constraint->aspectRatio();});

                   $detail_dir     = $row['detail_dir'];
                   $detail_name    = $img_name.'-detail';

                   $img->save(public_path().'/'.$detail_dir.'/'.$detail_name.'.'.$ext,100);

                   //把生成的图片写入到数据库中
                   $img_descs      = Request::input('img_descs');

                  
                   $arr            =    [
                            
                                            'thumb'     =>$thumb_dir.'/'.$thumb_name.'.'.$ext,
                                            'img'       => $detail_dir.'/'.$detail_name.'.'.$ext,
                                            'original'  =>$original_dir.'/'.$original.'.'.$ext,
                                            'img_desc'=>$img_descs[$key],
                                        ];

                    
                   //一对多的关联关系来存储商品相册
                   $gallery       = GoodsGallery::create($arr);
                   $goods->gallery()->save($gallery);
              }

        }
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  处理上传图片的类型检测
    |
    |-------------------------------------------------------------------------------
    */
    public function goods_gallery_check(){

        $files            = Request::file('original_imgs');
        $nbr              = count($files) - 1;
        $rules            = [];

        foreach(range(0,$nbr) as $index){

            $rules['original_imgs.'.$index]   = 'image|max:4000';
        }

        $validator        = Validator::make(request()->all(),$rules);

        if($validator->fails()){

            return false;
        }

        return true;

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  删除商品的所有相册
    |
    |-------------------------------------------------------------------------------
    */
    public function delete_goods_gallery($id){

        $row        = DB::table('goods_gallery')->where('goods_id',$id)->get();

        if(empty($row)){

           return false;
        }

        foreach($row  as $item){

            @unlink(public_path().'/'.$item->thumb);
            @unlink(public_path().'/'.$item->img);
            @unlink(public_path().'/'.$item->original);
        }

        DB::table('goods_gallery')->where('goods_id',$id)->delete();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  获取商品图片的设置
    |
    |-------------------------------------------------------------------------------
    */
    public function get_config_value($code){

        $row            = DB::table('sys_config')
                            ->where('code',$code)
                            ->first();

        if($row){

            return $row->value;
        }

        return false;

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  重新生成新尺寸的商品图片
    |
    |-------------------------------------------------------------------------------
    */
    public function create_new_goods_image($id){

        $model            = GoodsGallery::find($id);

        if(empty($model)){

            return false;
        }


        $original      = $model->original;
        $old_thumb     = $model->thumb;
        $old_img       = $model->img;
        //删除旧的缩略图和商品详情页面图片
        @unlink(public_path().'/'.$model->thumb);
        @unlink(public_path().'/'.$model->img);

        //获取商品大图的尺寸
        $img_width      = $this->img_width;
        $img_height     = $this->img_height;
        //用上传的原图生成商品大图
        $img            = Image::make(public_path().'/'.$model->original)
                               ->resize($img_width,$img_height, function ($constraint) { $constraint->aspectRatio();});
        $img->save(public_path().'/'.$old_img,100);

        //获取商品缩略图尺寸
        $thumb_width    = $this->thumb_width;
        $thumb_height   = $this->thumb_height;
        //用上传的原图生成商品大图
        $img            = Image::make(public_path().'/'.$model->original)
                               ->resize($thumb_width,$thumb_height, function ($constraint) { $constraint->aspectRatio();});
        $img->save(public_path().'/'.$old_thumb,100);


    }
    
}
