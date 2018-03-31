<?php namespace Phpstore\Goods;

use Phpstore\Grid\TableData;
use Phpstore\Grid\Grid;
use Phpstore\Grid\Page;
use Phpstore\Grid\Common;
use Phpstore\Base\Goodslib;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Goods;
use App\Models\Attribute;
use App\Models\GoodsAttr;
use App\Models\GoodsRelation;
use App\Models\GoodsArticle;
use DB;
use Request;
use Phpstore\Crud\ImageLib;

/*
|-------------------------------------------------------------------------------
|
|   商品控制器里面的grid相应操作函数
|
|-------------------------------------------------------------------------------
|
|   tableDataInit  	    --------------- 初始化tableData实例 并赋值给grid实例
|   setTableDataCol		--------------- 设置tabledata实例需要显示的数据库字段
|   getData 		    --------------- 根据指定的字段 获取表格所需要显示的所有数据
|   getTableData($info) --------------- 根据返回的json格式数据 初始化新的tableData实例
|   searchData          --------------- grid模板页面 需要的搜索表单配置数组
|   searchInfo 			--------------- grid模板页面 ajax操作函数 需要的json格式参数
|                                       ps.ui.grid(ajax_url,_token ,json)
|   FormData            --------------- 生成添加商品时候的表单数据信息
|   EditData            --------------- 编辑商品时候生成表单的数组信息
|   delete_goods_image  --------------- 删除商品图片
|   softdelAction       --------------- 批量回收站操作
|   deleteAction        --------------- 批量删除操作
|
|-------------------------------------------------------------------------------
*/
class CommonHelper{

	protected $data;



	/*
	|----------------------------------------------------------------------------
	|
	|  构造函数
	|
	|----------------------------------------------------------------------------
	*/
	function __construct(){

		//定义商品的常用操作链接
        $this->list_url             = 'admin/goods';
        $this->edit_url             = 'admin/goods/edit/';
        $this->add_url              = 'admin/goods/add';
        $this->update_url           = 'admin/goods/update';
        $this->del_url              = 'admin/goods/del/';
        $this->batch_url            = 'admin/goods/batch';
        $this->preview_url          = 'goods/';
        $this->ajax_url             = 'admin/goods/grid';



	}


	/*
    |-------------------------------------------------------------------------------
    |
    |  初始化tableData 输出初始的商品列表dom元素
    |  设置 数据表   					table ---- goods
    |  设置排序方式  					orderBy('id','desc')
    |  设置等于搜索
    |
    |  brand_id  					品牌
    |  is_new    					新品
    |  is_best   					精品
    |  is_hot    					热卖
    |  is_on_sale 					上架
    |
    |  设置关键字搜索  				商品名称 goods_name
    |  where('goods_name','like',''.$goods_name.'')
    |
    |  设置whereIn操作
    |  whereIn('cat_id',[1,2,3,4,5])
    |  系统会根据以上条件拼接sql查询 把最终结果返回给grid类来处理
    |
    |-------------------------------------------------------------------------------
    */
    public function tableDataInit(){


        $tableData                  = new TableData();

        //设置参数
        $tableData->put('table','goods');
        $tableData->put('sort_name','id');
        $tableData->put('sort_value','desc');

        //设置等于搜索数组
        $tableData->addField('brand_id','');
        $tableData->addField('is_new','');
        $tableData->addField('is_best','');
        $tableData->addField('is_hot','');
        $tableData->addField('is_on_sale','');
        $tableData->addField('is_delete',0);

        //设置搜索关键字
        $tableData->keywords('goods_name','');

        //设置whereIn搜索
        $tableData->whereIn('cat_id',[]);


        //设置数据表格每列显示的字段名称
        $tableData              = $this->setTableDataCol($tableData);

         //给page设置参数
         $current_page           = 1;
         $per_page               = 20;
         $total                  = intval($tableData->total());
         $last_page              = ceil($total / $per_page);
         $tableData->page('current_page',$current_page);
         $tableData->page('per_page',$per_page);
         $tableData->page('total',$total);
         $tableData->page('last_page',$last_page);

         //获取个性化后的数据
         $data                   = $this->getData($tableData->toArray());
         $tableData->put('data',$data);

        return $tableData;

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   设置数据表中需要显示的所有数据字段 并根据需求格式化数据内容
    |
    |-------------------------------------------------------------------------------
    */
    public function setTableDataCol(TableData $tableData){

        //设置数据表格每列显示的字段名称
        $tableData->addCol('id','id','编号','100px');
        $tableData->addCol('goods_name','goods_name','商品名称','200px');
        $tableData->addCol('goods_thumb','goods_thumb_str','商品图片','100px');
        $tableData->addCol('cat_id','cat_name','商品分类','');
        $tableData->addCol('brand_id','brand_name','商品品牌','');
        $tableData->addCol('goods_sn','goods_sn','商品货号','');
        $tableData->addCol('shop_price','shop_price','商品价格','');
        $tableData->addCol('is_on_sale','is_on_sale_str','是否上架','');
        $tableData->addCol('is_new','is_new_str','新品','');
        $tableData->addCol('is_hot','is_hot_str','热卖','');
        $tableData->addCol('is_best','is_best_str','精品','');
        $tableData->addCol('sort_order','sort_order','排序','');
        $tableData->addCol('goods_number','goods_number','库存','');

        return $tableData;

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  把获取的数据 再进一步格式化
    |
    |-------------------------------------------------------------------------------
    */
    public function getData($data){

        if(empty($data)){

            return '';
        }

        foreach($data as $key=>$value){

            $goods                                  = Goods::getModel($value['id']);

            //alias赋值
            $data[$key]['goods_thumb_str']          = Common::image($goods->thumb());
            $data[$key]['is_on_sale_str']           = Common::get_tag_status($value['is_on_sale']);
            $data[$key]['is_new_str']               = Common::get_tag_status($value['is_new']);
            $data[$key]['is_hot_str']               = Common::get_tag_status($value['is_hot']);
            $data[$key]['is_best_str']              = Common::get_tag_status($value['is_best']);
            $data[$key]['brand_name']               = $goods->brand_name();
            $data[$key]['cat_name']                 = $goods->cat_name();

            //操作链接
            $data[$key]['edit_url']                 = Common::get_resource_edit_url('admin/goods',$value['id']);
            $data[$key]['del_url']                  = Common::get_del_url($this->del_url,$value['id']);
            $data[$key]['preview_url']= Common::get_preview_url($this->preview_url,$value['id'],'goods');
        }

        return $data;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  根据返回的json格式的数据  格式化相关数据
    |
    |-------------------------------------------------------------------------------
    */
    public function getTableData($info){


        $tableData                  = new TableData();

        $sort_name                  = $info->sort_name;
        $sort_value                 = $info->sort_value;
        $current_page               = $info->page;
        $per_page                   = $info->per_page;

        $fieldRow                   = $info->fieldRow;
        $keywords                   = $info->keywords;
        $whereIn                    = $info->whereIn;


        //设置参数
        $tableData->put('table','goods');
        $tableData->put('sort_name',$sort_name);
        $tableData->put('sort_value',$sort_value);

        //设置关键词
        if($keywords){

            foreach($keywords as $key=>$value){

                $tableData->keywords($key , $value);
            }
        }

        //设置fieldRow 等于搜索
        if($fieldRow){

            foreach($fieldRow as $key=>$value){

                $tableData->addField($key , $value);
            }
        }

        //设置whereIn搜索
        if($whereIn){

             $in_field              = $whereIn->in_field;
             $in_value              = $whereIn->in_value;

             //这里为商品分类  获取该分类下所有子类
             $row                   = Common::get_child_row($in_value);

             $tableData->whereIn($in_field,$row);
        }

        //设置数据表格每列显示的字段名称
        $tableData              = $this->setTableDataCol($tableData);

         //设置分页参数信息
         $total                  = intval($tableData->total());
         $last_page              = ceil($total / $per_page);
         $tableData->page('current_page',$current_page);
         $tableData->page('per_page',$per_page);
         $tableData->page('total',$total);
         $tableData->page('last_page',$last_page);

         //获取个性化后的数据
         $data                   = $this->getData($tableData->toArray());
         $tableData->put('data',$data);

         return $tableData;
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 生成grid页面 搜索表单的配置数组
    |
    |-------------------------------------------------------------------------------
    */
    public function searchData(){

        return [

                    [
                        'type'          => 'select',
                        'field'         => 'per_page',
                        'name'          => '分页大小',
                        'option_list'   => Common::get_per_page_option_list(),
                        'selected_name' => '5个/页',
                        'selected_value'=> 5,
                        'id'            => 'per_page',
                    ],

                    [
                        'type'          => 'select',
                        'field'         => 'cat_id',
                        'name'          => '商品分类',
                        'option_list'   =>  Category::cat_select(),
                        'selected_name' => '请选择商品分类',
                        'selected_value'=> 0,
                        'id'            => 'cat_id',
                    ],

                    [
                        'type'          => 'select',
                        'field'         => 'brand_id',
                        'name'          => '商品品牌',
                        'option_list'   => Brand::brand_option(),
                        'selected_name' => '全部',
                        'selected_value'=> 99999,
                        'id'            => 'brand_id',
                    ],



                    [
                        'type'          => 'select',
                        'field'         => 'is_new',
                        'name'          => '是新品',
                        'option_list'   => Common::get_common_option_list(),
                        'selected_name' => '全部',
                        'selected_value'=> 99999,
                        'id'            => 'is_new',
                    ],

                    [
                        'type'          => 'select',
                        'field'         => 'is_hot',
                        'name'          => '精品',
                        'option_list'   => Common::get_common_option_list(),
                        'selected_name' => '全部',
                        'selected_value'=> 99999,
                        'id'            => 'is_hot',
                    ],

                    [
                        'type'          => 'select',
                        'field'         => 'is_best',
                        'name'          => '是精品',
                        'option_list'   => Common::get_common_option_list(),
                        'selected_name' => '全部',
                        'selected_value'=> 99999,
                        'id'            => 'is_best',
                    ],

                    [
                        'type'          => 'select',
                        'field'         => 'is_on_sale',
                        'name'          => '上架',
                        'option_list'   => Common::get_common_option_list(),
                        'selected_name' => '全部',
                        'selected_value'=> 99999,
                        'id'            => 'is_on_sale',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'goods_name',
                        'name'          => '商品名称',
                        'value'         => '',
                        'id'            => 'goods_name',
                    ],

                    [
                        'type'          => 'hidden',
                        'field'         => 'is_delete',
                        'name'          => '非回收站商品',
                        'value'         => 0,
                        'id'            => 'is_delete',
                    ],


                    [
                        'type'          => 'button',
                        'name'          => '搜索',
                        'id'            => 'search-btn',
						'back_url' 	    =>url($this->list_url),
                    ],
        ];

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  把执行ajax的搜索参数 用json格式化后 传递给grid页面
    |
    |-------------------------------------------------------------------------------
    */
    public function searchInfo(){

        $row    = [

                    'keywords'=>[
                                    ['field'=>'goods_name','value'=>'']
                    ],

                    'fieldRow'=>[
                                    ['field'=>'is_new','value'=>''],
                                    ['field'=>'is_best','value'=>''],
                                    ['field'=>'is_hot','value'=>''],
                                    ['field'=>'is_on_sale','value'=>''],
                                    ['field'=>'brand_id','value'=>''],
                                    ['field'=>'is_delete','value'=>''],

                    ],

                    'whereIn'=>[ 'field'=>'cat_id','value'=>''],
        ];


        return  json_encode($row,JSON_UNESCAPED_UNICODE);
    }






    /*
    |-------------------------------------------------------------------------------
    |
    | 删除商品的图片
    |
    |-------------------------------------------------------------------------------
    */
    public function delete_goods_image($id){

        $model              = Goods::find($id);

        if(empty($model)){

            return ;
        }

        $goods_thumb        = $model->goods_thumb;
        $goods_img          = $model->goods_img;

        if($goods_thumb){

            @unlink(public_path().'/'.$goods_thumb);
        }

        if($goods_img){

            @unlink(public_path().'/'.$goods_img);
        }

        //删除商品相册表中的记录和图片
        $res              = DB::table('goods_gallery')
                              ->where('goods_id',$id)
                              ->get();

        if($res){

            foreach($res as $item){

                if($item->thumb){

                    @unlink(public_path().'/'.$item->thumb);
                }

                if($item->img){

                    @unlink(public_path().'/'.$item->img);
                }

                if($item->original){

                    @unlink(public_path().'/'.$item->original);
                }
            }

            //删除记录
            DB::table('goods_gallery')
              ->where('goods_id',$id)
              ->delete();
        }
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 批量回收站操作
    |
    |-------------------------------------------------------------------------------
    */
    public function softdelAction($ids){

        foreach($ids as $id){

            $model                  = Goods::find($id);
            $model->is_delete       = 1;
            $model->save();
        } 
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 批量删除操作
    |
    |-------------------------------------------------------------------------------
    */
    public function deleteAction($ids){

        foreach($ids as $id){

            $model                  = Goods::find($id);
            //删除商品图片和商品相册图片
            $model->ImageDelete();
            //删除商品相册
            $model->gallery()->delete();
            //删除模型本身
            $model->delete();
        }
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 返回系统的所有分类列表
    |
    |-------------------------------------------------------------------------------
    */
    public function cat_option_list(){

        $cat_list       = Category::all();
        $str            = '';


        foreach($cat_list as $item){

            $str .='<option value="'.$item->id.'">'.$item->cat_name.'</option>';
        }

        return $str;

    }



		/*
        |-------------------------------------------------------------------------------
        |
        | 根据 cat_id  brand_id   keywords  返回商品列表
        |
        |-------------------------------------------------------------------------------
        */
		public function search_goods_list($cat_id ,$brand_id ,$keywords){

			   $query  					= DB::table('goods');
				 $cat_id 					= intval($cat_id);
				 $brand_id 				= intval($brand_id);
				 $row 						= [];

				 if($cat_id > 0){

						//获取该分类下所有子类的数组
					  $query 			  = $query->where('cat_id',$cat_id);
				 }

				 if($brand_id > 0){

					  $query 				= $query->where('brand_id',$brand_id);
				 }

				 if($keywords){

					  $query 				= $query->where('goods_name','like','%'.$keywords.'%');
				 }

				 $query 					= $query->take(10)->get();

				 if($query){

					   foreach($query as $item){

							   $row[]  =  [

									 							'id'=>$item->id,
																'goods_name'=>$item->goods_name,
																'shop_price'=>$item->shop_price,

								 						];
						 }

				 }

				 return $row;
		}

		/*
        |-------------------------------------------------------------------------------
        |
        | 根据 cat_id  brand_id   keywords  返回商品列表
        |
        |-------------------------------------------------------------------------------
        */
		public function search_article_list($cat_id ,$keywords){

			   $query  					= DB::table('article');
				 $cat_id 					= intval($cat_id);
				 $row 						= [];

				 if($cat_id > 0){

						//获取该分类下所有子类的数组
					  $query 			  = $query->where('cat_id',$cat_id);
				 }


				 if($keywords){

					  $query 				= $query->where('title','like','%'.$keywords.'%');
				 }

				 $query 					= $query->take(10)->get();

				 if($query){

					   foreach($query as $item){

							   $row[]  =  [

									 							'id'=>$item->id,
																'title'=>$item->title,


								 						];
						 }

				 }

				 return $row;
		}


		/*
        |-------------------------------------------------------------------------------
        |
        | 插入操作插入的数据
        |
        |-------------------------------------------------------------------------------
        */
		public function field(){

			  return [

									'goods_name',
									'goods_sn',
									'cat_id',
									'brand_id',
									'goods_number',
									'market_price',
									'shop_price',
									'promote_price',
									'give_integral',
									'diy_url',
									'goods_desc',
									'goods_weight',
									'warn_number',
									'is_new',
									'is_hot',
									'is_best',
									'keywords',
									'goods_brief',
									'seller_note',
                                    'sort_order',
				];
		}




    /*
    |-------------------------------------------------------------------------------
    |
    | 插入缩略图信息
    |
    |-------------------------------------------------------------------------------
    */
	public function thumb($id){

				 //初始化图片信息
				 $img 													= new ImageLib();
				 $img->put('dir','goods');
				 $img->put('file_name','goods_thumb');
				 $goods_thumb 									        = $img->upload_image();
				 
				 //初始化模型
				 $goods 												= Goods::find($id);

				 if($goods){

					 $goods->goods_thumb 					= $goods_thumb;
					 $goods->save();
				 }

	}


    /*
    |-------------------------------------------------------------------------------
    |
    | 插入商品相册
    |
    |-------------------------------------------------------------------------------
    */
	 public function goods_gallery($id){

			   if(Request::hasFile('originals')){

					 	 $files 	                        = Request::file('originals');

						 //初始化图片信息
						 $img 			                    = new ImageLib();
						 $img->put('dir','goods');

						 foreach($files as $file){

							 $ext                            = $file->getClientOriginalExtension();
	                         $filename                       = $file->getClientOriginalName();

	                         $img_dir                        = $img->create_dir();
	                         $img_name                       = $img->create_file_name();

							 $original                       = $img_name.'-original'.'.'.$ext;
	                         //移动图片文件到最终图片存放目录
	                        $file->move(public_path().'/'.$img_dir.'/original' , $original);
							//生成缩略图
							$img                             = Image::make($file)
																	 ->resize(280,280, function ($constraint) { $constraint->aspectRatio();});
							$thumb 					         = $img_name.'-thumb'.'.'.$ext;
							$img->save(public_path().'/'.$img_dir.'/'.$thumb,100);

							//生成商品大图
							$img                             = Image::make($file)
																    ->resize(500,500, function ($constraint) { $constraint->aspectRatio();});

							$detail_img		 = $img_name.'-img'.'.'.$ext;
							$img->save(public_path().'/'.$img_dir.'/'.$detail_img,100);

							//把上传后的商品路径 写入数据库中
							 $data  			= [

								 									'goods_id'=>$id,
																	'thumb'		=>$thumb,
																	'original'=>$original,
																	'img'			=>$detail_img,
							 ];

							 DB::table('goods_gallery')->insert($data);

						}

				 }

	}


		/*
        |-------------------------------------------------------------------------------
        |
        | 插入商品属性
        |
        |-------------------------------------------------------------------------------
        */
		public function goods_attr($model){

			    $attr_values 			= Request::input('attr_values');
				$attr_prices 			= Request::input('attr_prices');
				$attr_ids 				= Request::input('attr_ids');
                $goods_attr_ids         = Request::input('goods_attr_ids');

				if(empty($attr_values)|| empty($attr_ids)){

					 return false;
				}

				
				foreach($attr_values  as $key=>$value){

                        $goods_attr_id     = $goods_attr_ids[$key];
                        $goods_attr_id     = intval($goods_attr_id);

						$data 		= [

														'attr_id'=>$attr_ids[$key],
														'attr_value'=>$value,
														'attr_price'=>$attr_prices[$key],

						];

                        //如果为新添加的属性
                        if($goods_attr_id == 0){

                            $attr         = GoodsAttr::create($data);
                            $model->attr()->save($attr);
                        }
                        //如果属性已存在 则更新
                        elseif($goods_attr_id > 0){

                            $attr           = GoodsAttr::find($goods_attr_id);
                            $attr->update($data);
                        }
                    
				}
		}


		/*
		|-------------------------------------------------------------------------------
		|
		| 插入唯一属性
		|
		|-------------------------------------------------------------------------------
		*/
		public function goods_field($id){

			  $field_values 					= Request::input('field_values');
				$field_ids 							= Request::input('field_ids');

				if(empty($field_values)){

					  return false;
				}
				DB::table('goods_field')->where('goods_id',$id)->delete();
				foreach($field_values as $key=>$value){

							$data = [
													'field_id'=>$field_ids[$key],
													'field_value'=>$value,
													'goods_id'=>$id,
						 ];

						 DB::table('goods_field')->insert($data);

				}
		}



		/*
		|-------------------------------------------------------------------------------
		|
		| 插入关联商品信息
		|
		|-------------------------------------------------------------------------------
		*/
		public function goods($goods_id){

		     $ids             = request()->ids;
             if(empty($ids)){

                return false;
             }

             foreach($ids as $id){
                //允许关联
                if(GoodsRelation::allowRelation($goods_id,$id)){

                    GoodsRelation::create([ 'goods_id'=>$goods_id, 'relation_goods_id'=>$id ]);
                }
             }
		}



		/*
		|-------------------------------------------------------------------------------
		|
		| 插入关联新闻
		|
		|-------------------------------------------------------------------------------
		*/
		public function article($goods_id){

			 $article_ids        = request()->article_ids;
             if(count($article_ids) == 0){

                return false;
             }

             //清空
             GoodsArticle::where('goods_id',$goods_id)->delete();
             //更新记录
             foreach($article_ids as $article_id){
                 //如果记录不存在 而且输入合法 则创建记录
                 if(GoodsArticle::allowRelation($goods_id,$article_id)){

                     GoodsArticle::create(['goods_id'=>$goods_id,'article_id'=>$article_id]);
                 }
             }
		}


        /*
        |-------------------------------------------------------------------------------
        |
        | 处理促销日期
        |
        |-------------------------------------------------------------------------------
        */
        public function promote_date($id){

            $model                          = Goods::find($id);

            if(empty($model)){

                return false;
            }

            $start                          = Request::input('promote_start_date');
            $end                            = request('promote_end_date');

            if(!empty($start) && !empty($end)){

                $model->promote_start_date      = strtotime($start);
                $model->promote_end_date        = strtotime($end);
                $model->save();   

            }
        }
}
