<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as Controller;
use DB;
use HTML;
use Phpstore\Base\Lang;
use Phpstore\Log\Mylog;
use Request;


/*
|----------------------------------------------------------------------------------------
|
| 	view()                 返回包装后的模板
| 	get_path_url()         返回面包屑导航函数
|   unique() 			   用于解决laravel5.0的uinique函数错误编写的函数
|   unique_edit() 		   unique编辑时候的函数
|   ViewInit()			   给模板批量赋值
|   grid() 				   用于控制器中ajax排序搜索的处理
|
|---------------------------------------------------------------------------------------
*/
class BaseController extends Controller {

	public $view;
	public $page;
	public $tag;
	public $title;
	public $description;
	public $keywords;
	public $appname;
	public $menu;
	public $action_name;
	public $row;
	public $mylog;

	/*
	|--------------------------------------------------------------------------
	|
	| 	构造函数
	|
	|--------------------------------------------------------------------------
	*/
	function __construct(){


		$this->title 						= Lang::get('title');
		$this->description  				= Lang::get('description');
		$this->keywords 				    = Lang::get('keywords');
		$this->appname 						= Lang::get('appname');
		$this->copyright 					= Lang::get('copyright');
		$this->action_name 					= Lang::get('aciton_name');
		$this->form_validate_url 	  		= '';

		$menu 								= new \Phpstore\Base\Menu();
		$this->menu 	 				    = $menu->menu();
	    $this->middleware('privi');
		$this->middleware('log');
		$this->mylog 					    = new Mylog();
	}




	/*
	|--------------------------------------------------------------------------
	|
	| 初始化模板路径
	|
	|--------------------------------------------------------------------------
	*/
	public function view($templateName){

		$this->view 				= view('simple.'.$templateName);
		$this->view->crud_js 		= '';
		$row 						= [

										 'title',
										 'description',
										 'keywords',
										 'appname',
										 'copyright',
										 'action_name',
										 'menu',
										 'form_validate_url',
									  ];
		foreach($row as $item){

			$this->view->$item 	     = $this->$item;
		}

    	return $this->view;

	}


	/*
	|--------------------------------------------------------------------------
	|
	| 返回面包屑导航
	|
	|--------------------------------------------------------------------------
	*/
	public function get_path_url($url){

		$str  = 	'<div class="page-bar">'
				   .'<ol class="breadcrumb">'
				   .'<li>'
				   .'<i class="fa fa-home"></i>'
				   .HTML::link('admin/index',Lang::get('home'))
				   .'</li>'
				   .'<li>'
				   .$url
				   .'</li>'
				   .'</ol></div>';

	    return $str;
	}


	/*
	|--------------------------------------------------------------------------
	|
	| 判断数据是否重复
	|
	|--------------------------------------------------------------------------
	*/
	public function unique($table, $field_name){


		$row 		= DB::table($table)->where($field_name ,Request::input($field_name))->first();

		   if(empty($row)){

		   		return false;
		   }


		   return true;
	}


	/*
	|--------------------------------------------------------------------------
	|
	| 编辑数据的时候判断 是否存在重复数据
	|
	|--------------------------------------------------------------------------
	*/
	public function unique_edit($table,$field_name ,$field_id , $id){


		 $row 		= DB::table($table)
		 				  ->where($field_name , Request::input($field_name))
		 				  ->where($field_id,'!=',$id)
		 				  ->first();

		 if($row){

		 	return true;
		 }

		 else{

		 	return false;
		 }
	}


	/*
    |-------------------------------------------------------------------------------
    |
    |  给模板批量赋值
    |
    |-------------------------------------------------------------------------------
    */
    public function ViewInit(Array $row , $view){

        foreach($row as $key=>$value){

        	$view->$key  = $value;
        }

        return $view;
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  生成javascript链接
    |
    |-------------------------------------------------------------------------------
    */
    public function create_script($url){

    	return '<script type="text/javascript" src="'.$url.'"></script>';
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 输出json格式的数据
    |
    |-------------------------------------------------------------------------------
    */
    public function toJSON($arr){

        echo json_encode($arr, JSON_UNESCAPED_UNICODE);
        exit;
    }
}
