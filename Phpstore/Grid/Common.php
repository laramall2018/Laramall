<?php namespace Phpstore\Grid;

use HTML;
use DB;
use Phpstore\Base\Lang;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Goods;
use App\Models\CitySite;
use App\Models\Attribute;
use App\Models\GoodsAttr;
use App\Models\GoodsGallery;
use App\Models\ArticleCat;
use App\Models\Role;
use Phpstore\Base\Goodslib;
use App\Models\UserRank;
use App\Models\Type;
use Form;
use App\User;


	/*
    |-------------------------------------------------------------------------------
    |
	|  phpstore 全新的grid系统所需要使用的基础函数
    |
	|-------------------------------------------------------------------------------
	|
    |  get_tag_status($tag)                     根据给定的标签的值返回相应的图标
    |  image($img_src)                          根据图片链接 返回图片的标签
    |  get_edit_url($edit_url,$id)              返回编辑链接 类似 admin/goods/edit/{id}
    |  get_resource_edit_url($model,$id)        返回resource路由的编辑链接
    |                                           admin/goods/{id}/edit
    |  get_del_url($del_url,$id)                返回删除链接  类似 admin/goods/del/{id}
    |  get_preview_url($url , $id,$table)       返回预览链接  类似 goods/preview/{id}
    |  get_brand_name($brand_id)                获取品牌名称
    |  get_cat_name($cat_id)                    获取分类名称
    |  get_add_btn($add_url , $lang)            获取添加按钮的html
    |  get_per_page_option_list()               返回分页大小选择的select的option_list
    |  get_radio_list()                         返回简单单选按钮的option_list
    |  get_radio_show_list()                    返回简单单选按钮的option_list 第二种
    |  get_brand_option_list()                  获取品牌选择下拉option_list
    |  get_common_option_list()                 获取简单的select下拉option_list
    |  get_child_row($id)                       获取该分类下所有子类的数组（包含该分类)
    |                                           用于whewreIn('cat_id',$row)搜索
    |  batch_all_btn()                          返回批量删除，批量回收站的html元素按钮
    |  batch_del_btn()                          返回批量删除按钮的html元素
    |
	|-------------------------------------------------------------------------------
	*/
	class Common{


	    protected $row;
		/*
    	|-------------------------------------------------------------------------------
    	|
    	| 构造函数
    	|
    	|-------------------------------------------------------------------------------
    	*/
    	function __construct(){



    	}



    	/*
    	|-------------------------------------------------------------------------------
    	|
    	|  静态函数  获取状态型的数据
    	|
    	|-------------------------------------------------------------------------------
    	*/
    	public static function get_tag_status($tag){

    		 if($tag == 1){

    		 	return '<span class="blue"><i class="fa fa-check"></i></span>';
    		 }

    		 return '<span class="blue"><i class="fa fa-times"></i></span>';
    	}


    	/*
    	|-------------------------------------------------------------------------------
    	|
    	|  静态函数  格式化图片显示模式
    	|
    	|-------------------------------------------------------------------------------
    	*/
    	public static function image($img){

    		if(empty($img)){

    			return '';
    		}

				$str 					= '<img src="'.url($img).'" class="thumb img-circle">';

    		return $str;
    	}


    	/*
    	|-------------------------------------------------------------------------------
    	|
    	|  获取编辑操作链接
    	|
    	|-------------------------------------------------------------------------------
    	*/
    	public static function get_edit_url($url, $id){


    		$str  = '<i class="fa fa-edit"></i><a href="'.url($url.$id).'">'.Lang::get('edit').'</a>';

    		return $str;
    	}


        /*
        |-------------------------------------------------------------------------------
        |
        |  获取资源路由的编辑链接 get_resource_edit($model,$id)
        |
        |-------------------------------------------------------------------------------
        */
        public static function get_resource_edit_url($model,$id){

            $str  = '<a class="btn btn-primary" href="'.url($model.'/'.$id.'/edit').'">'
                    .'<span class="glyphicon glyphicon-pencil"></span>'
                    .Lang::get('edit')
                    .'</a>';
            return $str;


        }


    	/*
        |-------------------------------------------------------------------------------
        |
        |  获取删除操作链接
        |
        |-------------------------------------------------------------------------------
        */
        public static function get_del_url($url,$id){

            $dataUrl        = url($url.$id);
            $delClass       = 'btn btn-danger del-confirm act';
            $row            = ['class'=>$delClass,'data-url'=>$dataUrl];


            $str            =  '<a href="'.$dataUrl.'" class="'.$delClass.'" data-url="'.$dataUrl.'">'
                              .'<span class="glyphicon glyphicon-remove"></span>'
                              .Lang::get('delete')
                              .'</a>';
            return $str;
        }


    	/*
        |-------------------------------------------------------------------------------
        |
        |   获取预览链接
        |
        |-------------------------------------------------------------------------------
        */
        public static function get_preview_url($url , $id,$table){

            $row        = DB::table($table)->where('id',$id)->first();
            $fa         = '<i class="fa fa-share"></i>';

            if(empty($row)){

                return '';
            }

            if(empty($row->diy_url)){


                $str        = '<a class="btn btn-success act" href="'.url($url.$id).'" target="_blank">'
                              .$fa
                              .Lang::get('preview')
                              .'</a>';
                return $str;

            }

                $str        = '<a class="btn btn-success act" href="'.url($table.'/'.$row->diy_url).'" target="_blank">'
                              .$fa
                              .Lang::get('preview')
                              .'</a>';

                return $str;
        }



    	/*
    	|-------------------------------------------------------------------------------
    	|
    	|   返回品牌名称
    	|
    	|-------------------------------------------------------------------------------
    	*/
    	public static function get_brand_name($id){


    		$brand 			= Brand::find($id);

    		if(empty($brand)){

    			return '';
    		}

    		return $brand->brand_name;
    	}



    	/*
    	|-------------------------------------------------------------------------------
    	|
    	|  返回分类名称
    	|
    	|-------------------------------------------------------------------------------
    	*/
    	public static function get_cat_name($id){

    		$cat 			= Category::find($id);

    		if(empty($cat)){

    			return '';
    		}
    		return $cat->cat_name;
    	}


    	/*
    	|-------------------------------------------------------------------------------
    	|
    	|   返回添加按钮的html元素
    	|
    	|-------------------------------------------------------------------------------
    	*/
    	public static function get_add_btn($add_url , $lang){

            $str =  '<a href="'.url($add_url).'" class="btn btn-success">'
                    .'<i class="fa fa-edit"></i>'
                    .$lang
                    .'</a>';
            return $str;
    	}



    	/*
    	|-------------------------------------------------------------------------------
    	|
    	|  返回分页大小的option_list
    	|
    	|-------------------------------------------------------------------------------
    	*/
    	public static function get_per_page_option_list(){

    		$str  = '<option value="10">10个/页</option>'
    			   .'<option value="20" selected="selected">20个/页</option>'
    			   .'<option value="30">30个/页</option>'
    			   .'<option value="50">50个/页</option>'
    			   .'<option value="100">100个/页</option>';
    		return $str;
    	}


    	/*
    	|-------------------------------------------------------------------------------
    	|
    	|  返回radio表单的list
    	|
    	|-------------------------------------------------------------------------------
    	*/
    	public static function get_radio_list(){

    		return [

    					['name'=>Lang::get('radio_name_100'),'value'=>100],
    					['name'=>Lang::get('radio_name_0'),'value'=>0],
    					['name'=>Lang::get('radio_name_1'),'value'=>1],

    		];
    	}


        /*
        |-------------------------------------------------------------------------------
        |
        |  返回radio表单的list
        |
        |-------------------------------------------------------------------------------
        */
        public static function get_radio_add_list(){

            return [


                        ['name'=>Lang::get('radio_name_0'),'value'=>0],
                        ['name'=>Lang::get('radio_name_1'),'value'=>1],

            ];
        }

        /*
        |-------------------------------------------------------------------------------
        |
        |  返回属性radio表单的list
        |
        |-------------------------------------------------------------------------------
        */
        public static function get_radio_attr_list(){

            return [


                        ['name'=>Lang::get('attr_type_0'),'value'=>0],
                        ['name'=>Lang::get('attr_type_1'),'value'=>1],


            ];
        }

        /*
        |-------------------------------------------------------------------------------
        |
        |  返回radio表单的list
        |
        |-------------------------------------------------------------------------------
        */
        public static function get_radio_show_list(){

            return [


                        ['name'=>Lang::get('no_show'),'value'=>0],
                        ['name'=>Lang::get('is_show'),'value'=>1],

            ];
        }

    	/*
    	|-------------------------------------------------------------------------------
    	|
    	|  获取品牌列表
    	|
    	|-------------------------------------------------------------------------------
    	*/
    	public static function get_brand_option_list(){

    		 $brand_list 			= Brand::all();

    		 if(empty($brand_list)){

    		 	return '';
    		 }

    		 $str  					= '';

    		 foreach($brand_list as $item){

    		 	 $str .= '<option value="'.$item->id.'">'.$item->brand_name.'</option>';
    		 }

    		 return $str;
    	}

        /*
        |-------------------------------------------------------------------------------
        |
        |  获取通用的下拉选择菜单
        |
        |-------------------------------------------------------------------------------
        */
        public static function get_common_option_list(){

            $str    = '<option value="0">不是</option>'
                     .'<option value="1">是</option>';

            return $str;
        }



        /*
        |-------------------------------------------------------------------------------
        |
        |   获取商品分类下的所有子类
        |
        |-------------------------------------------------------------------------------
        */
        public static function get_child_row($id){

            return (array_unique(array_merge(array($id), array_keys(Goodslib::cat_list($id, 0, false)))));
        }



        /*
        |-------------------------------------------------------------------------------
        |
        |  生成批量删除 和 批量回收站按钮
        |
        |-------------------------------------------------------------------------------
        */
        public static function batch_all_btn(){

            $str    = '<div class="form-group">'
                     .'<span class="btn del-btn btn-danger" data-value="softdel">'
                     .'<i class="fa fa-refresh"></i>批量回收站'
                     .'</span>'
                     .'&nbsp;&nbsp;'
                     .'<span class="btn del-btn btn-primary" data-value="delete"><i class="fa fa-times"></i>批量删除</span>'
                     .'</div>';

            return $str;
        }

        /*
        |-------------------------------------------------------------------------------
        |
        |  生成批量删除 和 批量回收站按钮
        |
        |-------------------------------------------------------------------------------
        */
        public static function batch_all_btn_string($cycle_name ,$delete_name){

            $str    = '<div class="form-group">'
                     .'<span class="btn del-btn btn-danger" data-value="softdel">'
                     .'<i class="fa fa-refresh"></i>'.$cycle_name
                     .'</span>'
                     .'&nbsp;&nbsp;'
                     .'<span class="btn del-btn btn-primary" data-value="delete">'
                     .'<i class="fa fa-times"></i>'
                     .$delete_name
                     .'</span>'
                     .'</div>';

            return $str;
        }


        /*
        |-------------------------------------------------------------------------------
        |
        |  生成批量删除按钮
        |
        |-------------------------------------------------------------------------------
        */
        public static function batch_del_btn(){

            $str    = '<div class="form-group">'
                     .'<span class="btn del-btn blue btn-danger" data-value="delete"><i class="fa fa-times"></i>批量删除</span>'
                     .'</div>';

            return $str;
        }


        


        /*
        |-------------------------------------------------------------------------------
        |
        |  获取分类下商品个数
        |
        |-------------------------------------------------------------------------------
        */
        public static function get_goods_num($cat_id){

            return Goods::where('cat_id',$cat_id)->count();
        }


        /*
        |-------------------------------------------------------------------------------
        |
        |  获取类型名称
        |
        |-------------------------------------------------------------------------------
        */
        public static function get_type_name($type,$name){

            $type_tag       = $name.'_'.$type;

            return Lang::get($type_tag);
        }


        /*
        |-------------------------------------------------------------------------------
        |
        |  返回自定义导航栏的位置
        |
        |-------------------------------------------------------------------------------
        */
        public static function position_arr(){

            return  [

                        ['position'=>'top','name'=>'顶部导航'],
                        ['position'=>'middle','name'=>'中间导航'],
                        ['position'=>'bottom','name'=>'底部导航'],
                        ['position'=>'1f','name'=>'1f'],
                        ['position'=>'2f','name'=>'2f'],
                        ['position'=>'3f','name'=>'3f'],
                        ['position'=>'4f','name'=>'4f'],
                        ['position'=>'5f','name'=>'5f'],
            ];
        }


        /*
        |-------------------------------------------------------------------------------
        |
        |  返回自定义导航栏的所有位置
        |
        |-------------------------------------------------------------------------------
        */
        public static function get_nav_position_list(){

            $row        = self::position_arr();
            $str        = '';

            foreach($row as $item){

                $str .= '<option value="'.$item['position'].'">'.$item['name'].'</option>';

            }

            return $str;
        }

        /*
        |-------------------------------------------------------------------------------
        |
        |  返回导航栏的位置名称
        |
        |-------------------------------------------------------------------------------
        */
        public static function get_nav_position_name($position){

            $row        = self::position_arr();

            foreach($row as $item){

                if($item['position']== $position){

                    return $item['name'];
                }
            }

            return '';
        }


        /*
        |-------------------------------------------------------------------------------
        |
        |  获取站点地区名称
        |
        |-------------------------------------------------------------------------------
        */
        public static function get_site_name($site_id){

            $site       = CitySite::find($site_id);

            if(empty($site)){

                return '';
            }

            return $site->site_name;

        }

        /*
        |-------------------------------------------------------------------------------
        |
        |  获取站点列表 option_list
        |
        |-------------------------------------------------------------------------------
        */
        public static function get_site_option_list(){

            $site           = CitySite::all();
            $str            = '';

            if(empty($site)){

                return $str;
            }

            foreach($site as $item){

                $str .= '<option value="'.$item->id.'">'.$item->site_name.'</option>';
            }

            return $str;
        }



        /*
        |-------------------------------------------------------------------------------
        |
        | 获取多选按钮的数组值
        |
        |-------------------------------------------------------------------------------
        */
        public static function get_site_checkbox_list(){


            $site              = CitySite::all();
            $row               = [];

            if(empty($site)){

                return $row;
            }

            foreach($site as $key=>$value){

                $row[$key]['name']      = $value->site_name;
                $row[$key]['value']     = $value->site_code;
            }

            return $row;
        }


        /*
        |-------------------------------------------------------------------------------
        |
        | 返回多选表单被选中的值
        |
        |-------------------------------------------------------------------------------
        */
        public static function get_site_checked(){

            return ['beijing'];
        }


        /*
        |-------------------------------------------------------------------------------
        |
        | 返回被选中的分站列表
        |
        |-------------------------------------------------------------------------------
        */
        public static function get_site_checked_edit($site_list){

            return explode('|',$site_list);
        }


        /*
        |-------------------------------------------------------------------------------
        |
        | 返回所有属性名称列表
        |
        |-------------------------------------------------------------------------------
        */
        public static function get_goods_attr_list(){


            $attr_list          = Attribute::all();
            $str                = '';

            foreach($attr_list as $item){

                $str .= '<option value="'.$item->id.'">'.$item->attr_name.'</option>';
            }

            return $str;

        }

        /*
        |-------------------------------------------------------------------------------
        |
        | 获取商品的缩略图
        |
        |-------------------------------------------------------------------------------
        */
        public static function get_goods_thumb($goods_id){

            $goods              = Goods::find($goods_id);

            if(empty($goods)){

                return ;
            }

            if($goods->goods_thumb){

                return HTML::image($goods->goods_thumb,$goods->goods_name,['class'=>'thumb']);
            }

            $goods_gallery      = GoodsGallery::where('goods_id',$goods_id)->first();

            if($goods_gallery){

                if($goods_gallery->thumb){

                    return HTML::image($goods_gallery->thumb,$goods->goods_name,['class'=>'thumb']);
                }
            }

        }

		/*
        |-------------------------------------------------------------------------------
        |
        | 获取新闻分类的名称
        |
        |-------------------------------------------------------------------------------
        */
		public static function get_article_cat_name($id){

			$cat 				= ArticleCat::find($id);

			if(empty($cat)){

				return '一级分类';
			}

			else{

					return $cat->cat_name;
			    }

		}


                /*
                |-------------------------------------------------------------------------------
                |
                | 获取用户名称
                |
                |-------------------------------------------------------------------------------
                */
                public static function get_user_name($user_id){

                         $user          = User::find($user_id);

                             if(empty($user)){

                                  return '';
                             }

                             return $user->username;
                }



				/*
				|-------------------------------------------------------------------------------
				|
				| 获取等级名称
				|
				|-------------------------------------------------------------------------------
				*/
				public static function get_rank_name($rank_id){

					   $user_rank 				= UserRank::find($rank_id);

						 if(empty($user_rank)){

							   return '';
						 }

						 return $user_rank->rank_name;
				}


				/*
				|-------------------------------------------------------------------------------
				|
				| 是否显示 is_show()
				|
				|-------------------------------------------------------------------------------
				*/
				public static function is_show($tag){

						if($tag == 1){

							return '<i class="fa fa-check"></i>';
						}

						return '<i class="fa fa-times"></i>';

				}


				/*
				|-------------------------------------------------------------------------------
				|
				|  获取一级分类菜单
				|
				|-------------------------------------------------------------------------------
				*/
				public static  function get_one_cat_option_list(){

					  $row 		= DB::table('category')->where('parent_id',0)->get();
						$str 		= '<option value="0">请选择</option>';

						foreach($row as $item){

							$str .= '<option value="'.$item->id.'">'.$item->cat_name.'</option>';

						}

						return $str;

				}


				/*
				|-------------------------------------------------------------------------------
				|
				|  获取添加按钮链接
				|
				|-------------------------------------------------------------------------------
				*/
				public static  function get_add_attr_url($list_url , $id){

						$str  = '<a href="'.url($list_url.'/'.$id.'/attribute').'">添加属性</a>';
						return $str;

				}


				/*
				|-------------------------------------------------------------------------------
				|
				|  获取商品类型
				|
				|-------------------------------------------------------------------------------
				*/
				public static function get_goods_type($type_id){

					   $type 				= Type::find($type_id);

						 if(empty($type)){

							  return '';
						 }

						 return $type->type_name;
				}


				/*
				|-------------------------------------------------------------------------------
				|
				|  获取商品类型 下拉选项列表
				|
				|-------------------------------------------------------------------------------
				*/
				public static function get_goods_type_option_list($id){

					if(empty($id)){

						$id = 0;
					}

					$type  				    = Type::all();
					$str 						  = '<option value="0">请选择商品类型</option>';

					if($id > 0){

							$row 				= DB::table('attribute as a')
															->leftjoin('goods_attr as ga','ga.attr_id','=','a.id')
															->leftjoin('goods_type as gt','gt.id','=','a.type_id')
															->where('ga.goods_id','=',$id)
															->select('gt.id','gt.type_name')
															->first();
							if($row){

									$str 				= '<option value="'.$row->id.'" selected="selected">'.$row->type_name.'</option>';
							}


					}
					foreach($type as $item){

						$str  .='<option value="'.$item->id.'">'.$item->type_name.'</option>';

					}

					return $str;

				}

        /*
        |-------------------------------------------------------------------------------
        |
        |  输出json格式的结果数据
        |
        |-------------------------------------------------------------------------------
        */
        public static function toJson($row){

             echo json_encode($row, JSON_UNESCAPED_UNICODE);
             exit;
        }


		/*
        |-------------------------------------------------------------------------------
        |
        |  获取新闻分类列表
        |
        |-------------------------------------------------------------------------------
        */
		public static function get_article_cat_option_list(){

			 $row 				= DB::table('article_cat')->get();
			 $str 				= '<option value="0">请选择</option>';

			 foreach($row as $item){

					$str 	  .= '<option value="'.$item->id.'">'.$item->cat_name.'</option>';
				}

				return $str;
		}


        /*
        |-------------------------------------------------------------------------------
        |
        |  获取商品相册信息
        |
        |-------------------------------------------------------------------------------
        */
        public static function get_goods_gallery($id){

            $row            = DB::table('goods_gallery')->where('goods_id',$id)->get();
            return $row;

        }

		/*
        |-------------------------------------------------------------------------------
        |
        |  获取商品属性列表
        |
        |-------------------------------------------------------------------------------
        */
		public static function get_goods_attr_list_edit($id){

						$goods_attr 			= DB::table('goods_attr as ga')
																	->leftjoin('attribute as a','a.id','=','ga.attr_id')
																	->where('ga.goods_id','=',$id)
																	->select('ga.attr_id','ga.attr_value','ga.attr_price','a.attr_name')
																	->get();

						if(empty($goods_attr)){
							 return false;
						}

						$str = '';

						foreach($goods_attr as $item){

								$str 		.= '<div class="form-group">'
													.'<label class="col-md-3 control-label">'.$item->attr_name.'</label>'
													.'<div class="col-md-2">'
													.'<input type="text" class="form-control" name="attr_values[]" value="'.$item->attr_value.'">'
													.'</div>'
													.'<label class="col-md-1 control-label">属性价格</label>'
													.'<div class="col-md-2">'
													.'<input type="text" class="form-control" name="attr_prices[]" value="'.$item->attr_price.'" >'
													.'</div>'
													.'<div class="col-md-2">'
													.'<span class="btn btn-success add-attr-btn">'
													.'<i class="fa fa-plus"></i>添加'
													.'</span>'
													.'<span class="btn btn-default del-attr-btn">'
													.'<i class="fa fa-times"></i>删除'
													.'</span>'
													.'</div>'
													.'<input type="hidden" name="attr_ids[]" value="'.$item->attr_id.'">'
													.'</div>';

						}

						return $str;

				}


				/*
				|-------------------------------------------------------------------------------
				|
				|  获取商品字段信息
				|
				|-------------------------------------------------------------------------------
				*/
				public static function get_goods_field_list_edit($id){


							$field_list 			= DB::table('goods_field as gf')
																		->leftjoin('field as f','f.id','=','gf.field_id')
																		->where('gf.goods_id','=',$id)
																		->select('gf.field_value','f.field_name','gf.field_id')
																		->get();
							$str 						  = '';

							if(empty($field_list)){

								  return false;
							}

							foreach($field_list as $item){

								  $str .='<div class="form-group">'
												.'<label class="col-md-3 control-label">'.$item->field_name.'</label>'
												.'<div class="col-md-4">'
												.'<input type="text" class="form-control" name="field_values[]" value="'.$item->field_value.'">'
												.'</div>'
												.'<input type="hidden" name="field_ids[]" value="'.$item->field_id.'">'
												.'</div>';
							}

							return $str;
				}


				/*
				|-------------------------------------------------------------------------------
				|
				|  获取关联商品信息
				|
				|-------------------------------------------------------------------------------
				*/
				public static function get_goods_relations_list($id){

							$goods_list 		= DB::table('goods_relation as gr')
																	->leftjoin('goods as g','g.id','=','gr.relation_goods_id')
																  ->where('gr.goods_id','=',$id)
																	->select('g.goods_name','gr.relation_goods_id as id')
																	->get();
							return $goods_list;
				}


				/*
				|-------------------------------------------------------------------------------
				|
				|  获取关联新闻信息
				|
				|-------------------------------------------------------------------------------
				*/
				public static function get_goods_article_list_edit($id){

						$article_list 		= DB::table('article as a')
																	->leftjoin('goods_article as ga','ga.article_id','=','a.id')
																	->where('ga.goods_id','=',$id)
																	->select('a.title','a.id')
																	->get();

						return $article_list;
				}

        /**
         *
         * 根据用户编号获取用户名称
         *
         */
        public static function get_username($user_id){

            return (User::find($user_id))? User::find($user_id)->username : '匿名用户';
        }



        /*
        |-------------------------------------------------------------------------------
        |
        |  获取订单状态
        |  order_status         0 - 未确认 1 - 已确认  2 - 已发货 3 - 已取消  4 - 退货
        |  pay_status           0 - 未付款 1 - 已付款  2 - 已付款
        |  shipping_status      0 - 未确认 1 - 已发货  2 - 已收货 3 - 配货中
        |
        |-------------------------------------------------------------------------------
        */
        public static  function get_order_status($status , $type){


            $order_status_arr       = ['未确认','已确认','已发货','已取消','退货'];
            $pay_status_arr         = ['未付款','已付款','已付款'];
            $shipping_status_arr    = ['未确认','已发货','已收货','配货中'];

            $array_name             = $type.'_arr';
            $status                 = intval($status);

            if(strcmp($type , 'order_status') == 0){

                return $order_status_arr[$status];
            }
            elseif(strcmp($type , 'pay_status') == 0){

                return $pay_status_arr[$status];
            }
            else{

                return $shipping_status_arr[$status];
            }

        } 

        /*
        |-------------------------------------------------------------------------------
        |
        |  获取状态
        |
        |-------------------------------------------------------------------------------
        */
        public static function get_tag_value($tag){

            $row        = ['未激活','已激活'];

            if(in_array($tag,[0,1])){

                return $row[$tag];
            }

            return '未激活';
        }


        /*
        |-------------------------------------------------------------------------------
        |
        |  获取角色名称
        |
        |-------------------------------------------------------------------------------
        */
        public static function get_role_name($role_id){

            $model          = Role::find($role_id);

            if(empty($model)){

                return '';
            }

            return $model->role_name;
        }


        /*
        |-------------------------------------------------------------------------------
        |
        |  根据类型获取所有地区列表
        |
        |-------------------------------------------------------------------------------
        */
        public static function get_region_list($region_type){

             if(!in_array($region_type,[0,1,2,3])){

                return false;
             }

             $res           = DB::table('region')->where('region_type',$region_type)->get();

             return $res;
        }


        /*
        |-------------------------------------------------------------------------------
        |
        |  返回支付方式
        |
        |-------------------------------------------------------------------------------
        */
        public static function get_payment_option_list(){

             $res           = DB::table('payment')->get();
             $str           = '';

             if($res){

                foreach($res as $item){

                    $str    .= '<option value="'.$item->id.'">'.$item->pay_name.'</option>';
                }
             }

             return $str;
        }


        /*
        |-------------------------------------------------------------------------------
        |
        |  返回配送方式
        |
        |-------------------------------------------------------------------------------
        */
        public static function get_shipping_option_list(){

             $res           = DB::table('shipping')->get();
             $str           = '';

             if($res){

                foreach($res as $item){

                    $str    .= '<option value="'.$item->id.'">'.$item->shipping_name.'</option>';
                }
             }

             return $str;
        }


        /*
        |-------------------------------------------------------------------------------
        |
        |  获取所有新闻列表
        |
        |-------------------------------------------------------------------------------
        */
        public static function get_article_option_list(){

            $res            = DB::table('article')->take(200)->get();
            $str            = '';

            if($res){

                foreach($res as $item){

                    $str    .= '<option value="'.$item->id.'">'.$item->title.'</option>';  
                }
            }

            return $str;
        }


        /*
        |-------------------------------------------------------------------------------
        |
        |  获取商品名称
        |
        |-------------------------------------------------------------------------------
        */
        public static function get_goods_name($goods_id){

            $model              = Goods::find($goods_id);

            if(empty($model)){

                return '';
            }

            return $model->goods_name;
        }

        /*
        |-------------------------------------------------------------------------------
        |
        |  获取属性名称
        |
        |-------------------------------------------------------------------------------
        */
        public static function get_attr_name($attr_id){

            $model             = Attribute::find($attr_id);

            if(empty($model)){

                return '';
            }

            return $model->attr_name;
        }


        /*
        |-------------------------------------------------------------------------------
        |
        |  获取预览链接
        |
        |-------------------------------------------------------------------------------
        */
        public static function get_preview_btn($preview_url,$id){

            $url            = url($preview_url.$id);

            $str            = '<a href="'.$url.'" class="btn btn-success">'
                              .'<i class="fa fa-share"></i>'
                              .'预览'
                              .'</a>';

            return $str;

        }

    }
