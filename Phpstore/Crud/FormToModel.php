<?php namespace Phpstore\Crud;

use HTML;
use Input;
use Request;
use Hash;
use App\Models\Goods;
use App\Models\GoodsGallery;
use App\Models\Attribute;
use App\Models\GoodsAttr;
use DB;
use Phpstore\Oss\ImageOss;
use Storage;
use File;


/*
|-------------------------------------------------------------------------------
|
|  FormToModel类 递交表单把数据写入数据库表
|  表单递交过来的数据类型只有2种
|  文本表单
|  图片表单
|
|-------------------------------------------------------------------------------
*/

class FormToModel{

	protected  $model;  				     //数据表对应的模型
	protected  $row; 						 //数据表对应的字段数组
	protected  $dir;						 //图片上传的目录
	protected  $imagelib; 					 //图片上传控件
    protected  $type_list; 					 //处理商品表的字段
	protected  $updated_type;                //更新关联的数据表
    protected  $table;


	/*
    |-------------------------------------------------------------------------------
    |
    | 构造函数
    |
    |-------------------------------------------------------------------------------
    */
    function __construct(){


        $this->imagelib 								= new ImageOss();
        $this->type_list                = [

                                             'text',
                                             'radio',
                                             'select',
                                             'textarea',
                                             'ueditor_big',
                                             'ueditor',
                                          ];

		$this->updated_type 			= [

											  'goods_gallery',
											  'goods_attr',

										  ];



    }



    /*
    |-------------------------------------------------------------------------------
    |
    |  设置值
    |
    |-------------------------------------------------------------------------------
    */
    public function put($key , $value){

    	$this->$key 		=  $value;

    }



    /*
    |-------------------------------------------------------------------------------
    |
    |  获取值
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
    |  插入文本信息 和 图片上传的信息
    |
    |-------------------------------------------------------------------------------
    */
    public function insert(){


    	if(empty($this->row)){

    		return '';
    	}

    	foreach($this->row  as $item){

    		 //处理文本信息的插入
    		 if(in_array($item['type'],$this->type_list)){

                //没有设置插入开关 则插入数据
                if(empty($item['crud_tag'])){

                    $field                          = $item['field'];

                    $this->model->$field            = Input::get($field);
                }
    		 }

             //处理输入代码
             elseif($item['type'] == 'code'){

                $field                          = $item['field'];
                $this->model->$field            = htmlspecialchars(Input::get($field));

             }

             //处理密码
             elseif($item['type'] == 'password'){

                //如果输入了密码 则更新
                $field            = $item['field'];

                if(Request::input($field)){

                     $this->model->$field     = Hash::make(Request::input($field));

                }


             }

             //处理checkbox的值
             elseif($item['type'] == 'checkbox'){

                 $field               = $item['field2'];
                 $InputData           = Request::input($field);

                 if($InputData){

                    $str        = '';
                    foreach($InputData as $value){

                        $str    .= $value.'|';
                    }

                    $this->model->$field  = rtrim($str ,'|');
                 }
             }


    		 //处理图片信息的上传
    		 elseif($item['type'] == 'file'){

    		 			//$this->imagelib->put('dir',$this->dir);
    		 			$this->imagelib->put('file_name',$item['field']);
    		 			$upload_img 	= $this->imagelib->upload_image();

    		 			if($upload_img){

                                //删除旧图片
                                $field              = $item['field'];
                                $old_img            = $this->model->$field;

                                if($old_img){

                                    //删除旧图片
                                    if(Storage::exists($old_img)){

                                        Storage::delete($old_img);
                                    }
                                }

    		 					$this->model->$field = $upload_img;
    		 			}

    		 }


             //处理国家省会城市地区三级ajax联查数据
             elseif($item['type'] == 'pcd'){

                 $this->model->country      = Input::get('country');
                 $this->model->province     = Input::get('province');
                 $this->model->city         = Input::get('city');
                 $this->model->district     = Input::get('district');
             }

             //其他非显示表单 但是需要写入数据模型中的数据
             elseif($item['type'] == 'insert'){

                 $field                       = $item['field'];

                 $this->model->$field         = $item['value'];
             }


    	}

    	if($this->model->save()){

    		return true;
    	}
    	else{

    		return false;
    	}

    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  插入和此模型关联模型的值
    |
    |-------------------------------------------------------------------------------
    */
    public function update(){


        if(empty($this->row)){

            return ;
        }

        foreach($this->row as $item){


            if(in_array($item['type'],$this->updated_type)){

                //处理商品相册
                if($item['type'] == 'goods_gallery'){

                        $this->insert_goods_gallery();
                }
								elseif($item['type'] == 'goods_attr'){

												$this->insert_goods_attr();
								}
            }
        }


    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  更新商品相册
    |
    |-------------------------------------------------------------------------------
    */
    public function insert_goods_gallery(){

        $goods_id                   = $this->model->id;

        $goods_thumbs               = Request::input('goods_thumbs');
        $goods_imgs                 = Request::input('goods_imgs');
        $source_imgs                = Request::input('source_imgs');


        if(empty($goods_thumbs)||empty($goods_imgs)||empty($source_imgs)){

            return false;
        }

        foreach($goods_thumbs as $key=>$value){

            $row                     = GoodsGallery::where('goods_id','=',$goods_id)
                                            ->where('img','=',$goods_imgs[$key])
                                            ->where('thumb','=',$goods_thumbs[$key])
                                            ->where('original','=',$source_imgs[$key])
                                            ->first();

            //如果存在则删除
            if($row){

                GoodsGallery::where('goods_id','=',$goods_id)
                                            ->where('img','=',$goods_imgs[$key])
                                            ->where('thumb','=',$goods_thumbs[$key])
                                            ->where('original','=',$source_imgs[$key])
                                            ->delete();
            }


                 //重新添加
                 $model               = new GoodsGallery();
                 $model->goods_id     = $goods_id;
                 $model->img          = $goods_imgs[$key];
                 $model->thumb        = $goods_thumbs[$key];
                 $model->original     = $source_imgs[$key];
                 $model->save();

        }

        return true;
    }

	/*
    |-------------------------------------------------------------------------------
    |
    |  更新商品属性
    |
    |-------------------------------------------------------------------------------
    */
	public function insert_goods_attr(){

		$goods_id 					= $this->model->id;
		$goods_attr 				= GoodsAttr::where('goods_id',$goods_id)->get();

		$attr_value_list 	        = Request::input('attr_value_list');
		$attr_price_list 	        = Request::input('attr_price_list');
		$attr_ids 					= Request::input('attr_ids');

		if(empty($attr_value_list)){

			return false;
		}

		//清空所有该商品的商品属性值
		$goods_attr 				= GoodsAttr::where('goods_id',$goods_id)->get();
			
        if($goods_attr){

			GoodsAttr::where('goods_id',$goods_id)->delete();
		}

		foreach($attr_value_list  as $key=>$value){

				$model 								= new  GoodsAttr();
				$model->goods_id					= $goods_id;
				$model->attr_id 					= $attr_ids[$key];
				$model->attr_value 					= $value;
				$model->attr_price 					= $attr_price_list[$key];
				$model->save();

		}

				return true;
	}



    /*
    |-------------------------------------------------------------------------------
    |
    |  插入文本信息 和 图片上传的信息 通过DB模式
    |
    |-------------------------------------------------------------------------------
    */
    public function table_insert(){


        if(empty($this->row)){

            return '';
        }

        //待插入的数组
        $data                   = [];

        foreach($this->row  as $item){

             //处理文本信息的插入
             if(in_array($item['type'],$this->type_list)){

                //没有设置插入开关 则插入数据
                if(empty($item['crud_tag'])){

                    $data[$item['field']]    = Request::input($item['field']);
                }
             }

             //处理输入代码
             elseif($item['type'] == 'code'){

                $data[$item['field']]    = htmlspecialchars(Input::get($item['field']));

             }

             //处理密码
             elseif($item['type'] == 'password'){

                //如果输入了密码 则更新
                if(Request::input($item['field'])){

                     $data[$item['field']]    = Hash::make(Request::input($item['field']));

                }


             }

             //处理checkbox的值
             elseif($item['type'] == 'checkbox'){

                 $InputData           = Request::input($item['field2']);



                 if($InputData){

                    $str        = '';
                    foreach($InputData as $value){

                        $str    .= $value.'|';
                    }

                    $data[$item['field2']]   = rtrim($str ,'|');
                 }
             }


             //处理图片信息的上传
             elseif($item['type'] == 'file'){

                        $this->imagelib->set_value('dir',$this->dir);
                        $this->imagelib->set_value('file_name',$item['field']);
                        $upload_img     = $this->imagelib->upload_image();

                        if($upload_img){
                            
                                $data[$item['field']] = $upload_img;
                        }

             }


             //处理国家省会城市地区三级ajax联查数据
             elseif($item['type'] == 'pcd'){

                 $data['country']      = Input::get('country');
                 $data['province']     = Input::get('province');
                 $data['city']         = Input::get('city');
                 $data['district']     = Input::get('district');
             }

             //其他非显示表单 但是需要写入数据模型中的数据
             elseif($item['type'] == 'insert'){

                 $data[$item['field']] = $item['value'];
             }


        }

        if(DB::table($this->table)->insert($data)){

            return true;
        }
        else{

            return false;
        }

    }





}
