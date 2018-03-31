<?php

namespace Phpstore\Base;

class Lang{

    /*
    |-------------------------------------------------------------------------
    |
    | 具体语言包
    |
    |-------------------------------------------------------------------------
    */
    public static function info(){

    	return [

    			 //通用操作语言包
    			 'add' 									=>'添加',
    			 'edit'									=>'编辑',
    			 'delete'								=>'删除',
    			 'update'								=>'更新',
           'preview'              =>'预览',
           'is_show'              =>'显示',
           'no_show'              =>'不显示',
           'submit'               =>'确认',
           'update_submit'        =>'确认更新',


           //新闻相关语言包
    			 'back_article_list'	  =>'返回新闻列表',
    			 'article_list'					=>'所有新闻列表',
    			 'article'							=>'新闻',
    			 'add_article'					=>'添加新闻',
    			 'edit_article'					=>'编辑新闻',
           //新闻分类相关
           'back_article_cat_list'=>'返回新闻分类页面',
           'article_cat_list'     => '所有新闻分类页面',
           'add_article_cat'      => '添加新闻分类',
           'edit_article_cat'     => '编辑新闻分类',

          //商品管理相关的字段
          'back_goods_list'       =>'返回商品列表',
          'goods_list'            =>'商品列表',
          'add_goods'             =>'添加商品',
          'edit_goods'            =>'编辑商品',
          'back_brand_list'       =>'返回品牌列表',
          'brand_list'            =>'品牌列表',
          'add_brand'             =>'添加品牌',
          'edit_brand'            =>'编辑品牌',

          //用户管理
          'user_list'             =>'会员列表',
          'back_user_list'        =>'返回会员列表',
          'add_user'              =>'添加会员',
          'edit_user'             =>'编辑用户',

          //用户等级管理
          'user_rank_list'        =>'用户等级列表',
          'add_user_rank'         =>'添加用户等级',
          'edit_user_rank'        =>'编辑用户等级',

          //商品分类
          'cat_list'              =>'商品分类列表',
          'add_cat'               =>'添加商品分类',
          'edit_cat'              =>'编辑商品分类',
          //商品属性
          'attr_list'             =>'属性列表',
          'add_attr'              =>'添加属性',
          'attr_type_0'           =>'单选属性',
          'attr_type_1'           =>'多选属性',
          'attr_type_2'           =>'唯一属性（规格)',
          'img_tag'               =>'图片控件',
          'color_tag'             =>'颜色控件',
          'edit_attr'             =>'编辑属性',
          //一城一网字段管理
          'site_list'             =>'分站列表',
          'add_site'              =>'添加分站点',
          'edit_site'             =>'编辑分站',
          'back_site_list'        =>'返回分站点',

    			//系统字段
    			'title' 				        =>'北京麦维基于laravel框架的商城系统phpstore-b2b2c版',
        	'description'					  =>'phpstore b2b2c',
        	'keywords'					    =>'phpstore商城系统 phpstore b2b2c 商城系统',
        	'appname'          			=>'Phpstore b2b2c V1.0',
        	'copyright'        			=>'北京麦维创想科技有限公司版权所有',
        	'action_name'      			=>'系统提示信息',
        	'home'									=>'控制面板',

        	 //系统提示信息
        	'forbidden'							=>'模型不存在或者非法操作',
        	'fails'								  =>'操作执行失败',
          'empty'                 =>'您未选择任何项',

          //开发帮助中心
          'databases_title'       =>'系统所有数据表字段信息',

          //单选表单的value
          'radio_name_100'        =>'全部',
          'radio_name_0'          =>'不是',
          'radio_name_1'          =>'是',
          //自定义导航栏语言包
          'back_nav_list'         =>'返回导航栏列表',
          'nav_list'              =>'导航栏列表',
          'add_nav'               =>'添加导航栏',
          'edit_nav'              =>'编辑导航栏',
          //整站图片管理语言包
          'back_image_list'       =>'返回图片列表',
          'add_image'             =>'添加图片',
          'edit_image'            =>'编辑图片',
          'image_list'            =>'图片列表',

          //图片批量上传
          'uploadify'             =>'图片批量上传',

          //角色相关
          'role_list'             =>'所有角色',
          'add_role'              =>'添加角色',
          'edit_role'             =>'编辑角色',
          //角色相关
          'admin_list'            =>'管理员列表',
          'add_admin'             =>'添加管理员',
          'edit_admin'            =>'编辑管理员',

          //日志相关配置语言包
          'log_list'              =>'后台日志系统清单',
          //机构地址信息语言包
          'me_address_list'       =>'机构地址列表信息',
          'add_me_address'        => '添加机构地址',

          //添加类型
          'type_list'             =>'类型列表',
          'add_type'              =>'添加类型',
          'edit_type'             =>'编辑类型',
          'back_type_list'        =>'返回类型列表',

          //属性管理
          'add_attr'              =>'添加属性',
          'field_list'            =>'规格列表',
          'add_field'             =>'添加规格',
          'edit_field'            =>'编辑规格',


    	];
    }


    /*
    |-------------------------------------------------------------------------
    |
    | 静态方法获取语言包字段
    |
    |-------------------------------------------------------------------------
    */
    public static function get($key){

    	$row 			= self::info();

    	if(array_key_exists($key,$row)){

    		return $row[$key];
    	}

    	return '';
    }
}
