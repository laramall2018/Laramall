<?php namespace Phpstore\Base;

use HTML;
use App\Models\Privi;
use App\Models\Role;
use App\Models\RolePrivi;
use Auth;
use Cache;
use DB;
/*
|-------------------------------------------------------------------------------
|
|  帮助系统菜单
|
|-------------------------------------------------------------------------------
*/
class Menu{


	public $menuOne;
	public $menuTwo;



	/*
    |-------------------------------------------------------------------------------
	|
	|  一级菜单
	|
	|-------------------------------------------------------------------------------
	*/
	public function getMenuOne(){

		return [




			        [
								'name'=>'控制面板',
								'page'=>'index',
								'icon'=>'<i class="fa fa-tachometer"></i>'
				     ],


//				    [
//								'name'=>'网店常用设置',
//								'page'=>'common',
//								'icon'=>'<i class="fa fa-cube"></i>'
//				    ],
				    [
								'name'=>'商品管理',
								'page'=>'goods',
								'icon'=>'<i class="fa fa-home"></i>'
				    ],
				    [
								'name'=>'促销管理',
								'page'=>'promotion',
								'icon'=>'<i class="fa fa-home"></i>'
				    ],
					[
								'name'=>'订单管理',
								'page'=>'order',
								'icon'=>'<i class="fa fa-home"></i>'
					],
			        [
								'name'=>'用户管理',
								'page'=>'user',
								'icon'=>'<i class="fa fa-users"></i>'
				    ],
				    

						[
								'name'=>'开发帮助中心',
								'page'=>'dev',
								'icon'=>'<i class="fa fa-question-circle"></i>'
				    ],

					  [
								'name'=>'新闻管理',
								'page'=>'article',
								'icon'=>'<i class="fa fa-list-alt"></i>'
					  ],
					  /*[
								'name'=>'供货商管理',
								'page'=>'supplier',
								'icon'=>'<i class="fa fa-list-alt"></i>'
					  ],*/

//					 [
//								'name'=>'权限管理',
//								'page'=>'privi',
//								'icon'=>'<i class="fa fa-unlock"></i>'
//					 ],

					 [
								'name'=>'模板设置',
								'page'=>'template',
								'icon'=>'<i class="fa fa-hashtag"></i>'
					 ],

					 [
								'name'=>'商城系统配置',
								'page'=>'config',
								'icon'=>'<i class="fa fa-cube"></i>'
					 ],
					 /*[
								'name'=>'移动版本设置',
								'page'=>'mobile',
								'icon'=>'<i class="fa fa-cube"></i>'
					 ],*/

		];
	}

	/*
    |-------------------------------------------------------------------------------
	|
	|  二级菜单
	|
	|-------------------------------------------------------------------------------
	*/
	public function getMenuTwo(){


	 	return  [


	 					'common' =>[

	 										[

												'name'=>'自定义导航栏',
												'tag'=>'admin.nav.index',
												'url'=>url('admin/nav'),
												'icon'=>'<i class="fa fa-home"><i>'
										    ],

	 										[

												'name'=>'整站图片管理',
												'tag'=>'admin.image.index',
												'url'=>url('admin/image'),
												'icon'=>'<i class="fa fa-home"><i>'
										    ],
										    
										    [

												'name'=>'友情链接管理',
												'tag'=>'admin.link.index',
												'url'=>url('admin/link'),
												'icon'=>'<i class="fa fa-home"><i>'
										    ],
	 					],

	 					'index' =>[

	 										[

												'name'=>'系统信息',
												'tag'=>'admin.system.index',
												'url'=>url('admin/index'),
												'icon'=>'<i class="fa fa-home"><i>'
										    ],
	 					],


	 					'city' =>[

	 										[

												'name'=>'城市分站列表',
												'tag'=>'admin.site.index',
												'url'=>url('admin/site'),
												'icon'=>'<i class="fa fa-home"><i>'
										    ],
	 					],



	 					'goods' =>[

	 										[

												'name'=>'商品列表',
												'tag'=>'admin.goods.index',
												'url'=>url('admin/goods'),
												'icon'=>'<i class="icon-present"></i>'
										    ],

										    [

												'name'=>'商品分类',
												'tag'=>'admin.category.index',
												'url'=>url('admin/category'),
												'icon'=>'<i class="fa fa-home"><i>'
										    ],

										    [

												'name'=>'商品品牌',
												'tag'=>'admin.brand.index',
												'url'=>url('admin/brand'),
												'icon'=>'<i class="fa fa-home"><i>'
										    ],

												[

												'name'=>'商品类型管理',
												'tag'=>'admin.type.index',
												'url'=>url('admin/type'),
												
										    ],

										    [

												'name'=>'属性管理',
												'tag'=>'admin.attribute.index',
												'url'=>url('admin/attribute'),
												'icon'=>'<i class="fa fa-home"><i>'
										    ],

										    [

												'name'=>'商品规格',
												'tag'=>'admin.field.index',
												'url'=>url('admin/field'),
												'icon'=>'<i class="fa fa-home"><i>'
										    ],

										    [

												'name'=>'颜色属性管理',
												'tag'=>'admin.color.index',
												'url'=>url('admin/color'),
												'icon'=>'<i class="fa fa-home"><i>'
										    ],


										    [

												'name'=>'属性链货品管理',
												'tag'=>'admin.product.index',
												'url'=>url('admin/product'),
												'icon'=>'<i class="fa fa-home"><i>'
										    ],

										    [

												'name'=>'Excel导入导出',
												'tag'=>'admin.excel.index',
												'url'=>url('admin/excel'),
												'icon'=>'<i class="fa fa-home"><i>'
										    ],
										    [

												'name'=>'命令行批量添加商品',
												'tag'=>'admin.command.index',
												'url'=>url('admin/command'),
												'icon'=>'<i class="fa fa-home"><i>'
										    ],

										    [

												'name'=>'商品图片批量处理',
												'tag'=>'admin.goods.image',
												'url'=>url('admin/goods/image'),
												'icon'=>'<i class="fa fa-home"><i>'
										    ],

										    [

												'name'=>'标签管理',
												'tag'=>'admin.tag.index',
												'url'=>url('admin/tag'),
												'icon'=>'<i class="fa fa-home"><i>'
										    ],

										    [

												'name'=>'商品回收站',
												'tag'=>'admin.cycle.index',
												'url'=>url('admin/cycle'),
												'icon'=>'<i class="fa fa-home"><i>'
										    ],
	 					],

	 					'promotion'=>[
											[
												'name'=>'礼品卡列表',
												'tag'=>'admin.card.index',
												'url'=>url('admin/card'),
												'icon'=>'',
											],
								 ],


						'order'=>[
											[
												'name'=>'订单列表',
												'tag'=>'admin.order.index',
												'url'=>url('admin/order'),
												'icon'=>'',

											],
											[
												'name'=>'添加订单',
												'tag'=>'admin.order.create',
												'url'=>url('admin/order/create'),
											],
											[
												'name'=>'订单日志',
												'tag'=>'admin.order.log',
												'url'=>url('admin/order/log'),
											],

											[
												'name'=>'发货单管理',
												'tag'=>'admin.express.index',
												'url'=>url('admin/express'),
											],

											[
												'name'=>'退货管理',
												'tag'=>'admin.return.index',
												'url'=>url('admin/return'),
											],
											[
												'name'=>'订单打印',
												'tag'=>'admin.order.print',
												'url'=>url('admin/order/print'),
											],
						],

						'user' =>[

													[

															'name'=>'用户列表',
															'tag'=>'admin.user.index',
															'url'=>url('admin/user'),
															'icon'=>'<i class="icon-present"></i>'
													],

												  [

														'name'=>'会员等级',
														'tag'=>'admin.user_rank.index',
														'url'=>url('admin/user_rank'),
														'icon'=>'<i class="fa fa-home"><i>'
												  ],

												  [

														'name'=>'充值和提现',
														'tag'=>'admin.account.index',
														'url'=>url('admin/account'),
														'icon'=>'<i class="fa fa-home"><i>'
												  ],
												  [

														'name'=>'会员留言',
														'tag'=>'admin.message.index',
														'url'=>url('admin/message'),
														'icon'=>'<i class="fa fa-home"><i>'
												  ],

												  [

														'name'=>'短消息管理',
														'tag'=>'admin.sms.index',
														'url'=>url('admin/sms'),
														'icon'=>'<i class="fa fa-home"><i>'
												  ],

												  [

														'name'=>'演示账号管理',
														'tag'=>'admin.demo.index',
														'url'=>url('admin/demo'),
														'icon'=>'<i class="fa fa-home"><i>'
												  ],
						],


						'dev'	=>[


											[
												'name'=>'系统数据字典',
												'tag'=>'databases',
												'url'=>url('admin/databases'),
												'icon'=>'<i class="fa fa-cogs"></i>'

											],

											[
												'name'=>'centos安装',
												'tag'=>'redis',
												'url'=>url('/redis'),
												'icon'=>'<i class="fa fa-cogs"></i>'

											],

											[
												'name'=>'滚动组件',
												'tag'=>'carousel',
												'url'=>url('/carousel'),
												'icon'=>'<i class="fa fa-cogs"></i>',
											],

											[
												'name'=>'前端表单样式',
												'tag'=>'mwui',
												'url'=>url('mwui'),
												'icon'=>'<i class="fa fa-cogs"></i>',
											],


											[
												'name'=>'tabledata组件',
												'tag'=>'tabledata',
												'url'=>url('tabledata'),
												'icon'=>'<i class="fa fa-cogs"></i>'
											],

											[
												'name'=>'分页组件',
												'tag'=>'page',
												'url'=>url('/page'),
												'icon'=>'<i class="fa fa-cogs"></i>'
											],

											[
												'name'=>'grid组件',
												'tag'=>'grid',
												'url'=>url('grid'),
												'icon'=>'<i class="fa fa-cogs"></i>'
											],
						],

						'article'	 =>[
											[
												'name'=>'新闻列表',
												'tag'=>'admin.article.index',
												'url'=>url('admin/article'),
												'icon'=>'<i class="fa fa-cogs"></i>'
											],

											[
												'name'=>'新闻分类',
												'tag'=>'admin.article_cat.index',
												'url'=>url('admin/article_cat'),
												'icon'=>'<i class="fa fa-cogs"></i>'
											],
						],

						'supplier'	 =>[
											[
												'name'=>'供货商列表',
												'tag'=>'admin.supplier.index',
												'url'=>url('admin/supplier'),
												'icon'=>'<i class="fa fa-cogs"></i>'
											],

											
						],

						'privi'	 =>[
											[
												'name'=>'管理员列表',
												'tag'=>'admin.administrator.index',
												'url'=>url('admin/administrator'),
												'icon'=>'<i class="fa fa-cogs"></i>'
											],

											[
												'name'=>'系统所有权限清单',
												'tag'=>'admin.privi.index',
												'url'=>url('admin/privi'),
												'icon'=>'<i class="fa fa-cogs"></i>'
											],
											[
												'name'=>'角色管理',
												'tag'=>'admin.role.index',
												'url'=>url('admin/role'),
												'icon'=>'<i class="fa fa-cogs"></i>'
											],

											[
												'name'=>'日志管理',
												'tag'=>'admin.log.index',
												'url'=>url('admin/log'),
												'icon'=>'<i class="fa fa-cogs"></i>'
											],


											[
												'name'=>'退出登录',
												'tag'=>'admin.administrator.logout',
												'url'=>url('admin/administrator/logout'),
												'icon'=>'<i class="fa fa-cogs"></i>'
											],

						],

						'template' =>[
							                [
												'name'=>'模板设置',
												'tag'=>'admin.template.index',
												'url'=>url('admin/template'),
												'icon'=>'<i class="fa fa-cogs"></i>'
											],
											[
												'name'=>'模板颜色选择器',
												'tag'=>'admin.style.index',
												'url'=>url('admin/style'),
												'icon'=>'<i class="fa fa-cogs"></i>'
											],
									],

			            'config' =>[
							                [
												'name'=>'商城系统设置',
												'tag'=>'admin.config.index',
												'url'=>url('admin/config'),
												'icon'=>'<i class="fa fa-cogs"></i>'
											],

											[
												'name'=>'首页幻灯片设置',
												'tag'=>'admin.slider.index',
												'url'=>url('admin/slider'),
												'icon'=>'<i class="fa fa-cogs"></i>'
											],

											[
												'name'=>'分类广告管理',
												'tag'=>'admin.catad.index',
												'url'=>url('admin/catad'),
												'icon'=>'<i class="fa fa-cogs"></i>'
											],

											[
												'name'=>'支付方式',
												'tag'=>'admin.payment.index',
												'url'=>url('admin/payment'),
												'icon'=>'<i class="fa fa-cogs"></i>'
											],

											[
												'name'=>'配送方式',
												'tag'=>'admin.shipping.index',
												'url'=>url('admin/shipping'),
												'icon'=>'<i class="fa fa-cogs"></i>'
											],

											[
												'name'=>'地区运费设置',
												'tag'=>'admin.region_shipping.index',
												'url'=>url('admin/region_shipping'),
												'icon'=>'<i class="fa fa-cogs"></i>'
											],
											

						],

						'mobile' =>[
							                [
												'name'=>'wap版本基本设置',
												'tag'=>'admin.wap.index',
												'url'=>url('admin/wap'),
												'icon'=>'<i class="fa fa-cogs"></i>'
											],

											

						],


	    ];


	}


	/*
    |-------------------------------------------------------------------------------
	|
	|  获取菜单列表
	|
	|-------------------------------------------------------------------------------
	*/
	public function menu(){

		$data 		= $this->getMenuTwo();
		$menuOne 	= $this->getMenuOne();

		$str 		= '<ul class="nav panel-list">';

		foreach($menuOne as $item){


			if($this->check_admin_privi($item['page'])){


						$str 	 .='<li class="hoe-has-menu one" data-page="'.$item['page'].'">'
					   	   		 .'<a class="one" href="javascript:;">'
						   	 	 .$item['icon']
						   	 	 .'<span class="menu-text" style="font-weight:bold">'
						         .$item['name']
						         .'</span>'
						         .'<span class="selected"></span>'
						         .'</a>';

						$str     .= '<ul class="hoe-sub-menu">';

										if(array_key_exists($item['page'],$data)){

												foreach($data[$item['page']] as $value){

														if($this->check_admin_privi($value['tag'])){

																$str	.= '<li class="two" data-tag="'.$value['tag'].'">'
					    			   	   		   		  				.'<a href="'.$value['url'].'">'
					    			   	   		   	    				.'<span class="menu-text">'.$value['name'].'</span>'
					    			   	   		   	    				.'<span class="selected"></span>'
																		.'</a>'
					   					   		   	      				.'</li>';

														}
									    		}
						      			}
						$str .='</ul>';
						$str .='</li>';

			}
		}

		$str .='</ul>';
		return $str;

	}


	/*
    |-------------------------------------------------------------------------------
	|
	|  不做权限认证 获取左侧所有菜单
	|
	|-------------------------------------------------------------------------------
	*/
	public function get_all_menu(){

		$data 		= $this->getMenuTwo();
		$menuOne 	= $this->getMenuOne();

		$str 		= '<ul class="nav panel-list">';

		foreach($menuOne as $item){





						$str 	   .='<li class="hoe-has-menu one" data-page="'.$item['page'].'">'
					   	   		 .'<a class="one" href="javascript:;">'
						   	 		 .$item['icon']
						   	 		 .'<span class="menu-text">'
						         .$item['name']
						         .'</span>'
						         .'<span class="selected"></span>'
						         .'</a>';

						$str .= '<ul class="hoe-sub-menu">';



												foreach($data[$item['page']] as $value){



												$str	.= '<li class="two" data-tag="'.$value['tag'].'">'
					    			   	   		   		.'<a href="'.$value['url'].'">'
					    			   	   		   	    .'<span class="menu-text">'.$value['name'].'</span>'
					    			   	   		   	    .'<span class="selected"></span>'
														.'</a>'
					   					   		   	    .'</li>';


									     }
						$str .='</ul>';
					  $str .='</li>';


		}

		$str .='</ul>';
		return $str;

	}



	/*
    |-------------------------------------------------------------------------------
	|
	|  检测登录用户是否被授权执行该权限代码对应的链接操作
	|
	|-------------------------------------------------------------------------------
	*/
	public function check_admin_privi($privi_code){

		//如果未登录 返回 false
		if(!Auth::check('admin')){

			return false;
		}

		//获取登录管理员
		$admin 				= Auth::user('admin');

		if(count($admin->privi()) == 0){

			return false;
		}

		//如果当前登录用户 拥有该权限 则返回true
		if(in_array($privi_code ,$admin->privi())){

			return true;
		}
		
		//当前登录用户不拥有该权限
		return false;
	}

}
