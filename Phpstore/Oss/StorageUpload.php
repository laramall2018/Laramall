<?php

namespace Phpstore\Oss;

use Storage;
use File;
use Validator;
use Image;

/*
|-------------------------------------------------------------------------------
|
|  此类 主要用于处理图片上传至LS系统的Storage介质 （local 或者 oss ）
|
|-------------------------------------------------------------------------------
*/

class StorageUpload{

	public $width; 			 //压缩图片的宽度
	public $height;			 //压缩文件的高度
	public $file_name;		 //文件名称
	public $file;		     //文件资源
	public $upload_field;    //上传表单名称


	/*
    |-------------------------------------------------------------------------------
    |
    | 构造函数
    |
    |-------------------------------------------------------------------------------
    */
    public function __construct(){


    }



    /*
    |-------------------------------------------------------------------------------
    |
    |  上传图片至 local 和 oss
    |  $file  =   request()->file('upload_field') //上传的图片
    |  or
    |  $file  = storage_path($file_name); //本地的图片链接
    |
    |-------------------------------------------------------------------------------
    */
    public function storage_move(){

    	//local 本地
    	Storage::disk('local')->put($this->file_name,File::get($this->file));
    	//oss 云端
    	Storage::disk('oss')->put($this->file_name,File::get($this->file));

    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  重新生成图片的尺寸
    |  $file  为上传的图片 或者本地图片 或者远程链接
    |
    |  request()->file($file_name)
    |  storage_path($file_name)
    |  http://oss.phpstore.cn/files/test.png
    |
    |-------------------------------------------------------------------------------
    */
    public function resize(){

        //获取图片资源对象
        $img                            = Image::make($this->file);

        if(empty($img)){

        	return false;
        }

        //处理图片尺寸
        $img->resize($this->width, $this->height, function ($constraint) {
            
            $constraint->aspectRatio();
        });

        //移动到临时文件夹
        $img->save(storage_path().'/'.$this->file_name,100);
        
        //上传到oss
        Storage::disk('oss')->put($this->file_name,File::get(storage_path($this->file_name)));

    }

    
    /*
    |-------------------------------------------------------------------------------
    |
    |  检测上传文件的类型 是否是图片
    |
    |-------------------------------------------------------------------------------
    */
    public function image_type_check(){

    	$rules 			= [$this->upload_field => 'image'];
    	$validator 	 	= Validator::make(request()->all(),$rules);

    	return  ($validator->fails()) ? false : true;
    }
}