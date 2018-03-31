<?php namespace App\Http\Controllers\Admin;

use HTML;

class GridController extends BaseController{



    /*
    |-------------------------------------------------------------------------------
    |
    | 构造函数
    |
    |-------------------------------------------------------------------------------
    */

   
    public $page;
    public $tag;
    public $view;
    public $layout;

    function __construct(){

    	parent::__construct();
        $this->page     = 'dev';
        $this->tag      = 'grid';
    	
    	

    }


    /*
    |-------------------------------------------------------------------------------
    |
    | tabledata组件
    |
    |-------------------------------------------------------------------------------
    */
    public function tabledata(){

    	$view 						= $this->view('tabledata');
    	$view->page  				= $this->page;
    	$view->tag 					= 'tabledata';
        $view->path_url             = $this->get_path_url(HTML::link('/tabledata','tabledata组件'));

    	return $view;

    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 分页组件
    |
    |-------------------------------------------------------------------------------
    */
    public function page(){

        $view           = $this->view('page');
        $view->page     = $this->page;
        $view->tag      = 'page';
        $view->path_url = $this->get_path_url(HTML::link('/page','分页组件'));

        return $view;
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | grid组件
    |
    |-------------------------------------------------------------------------------
    */
    public function grid(){

        $view           = $this->view('grid');
        $view->page     = $this->page;
        $view->tag      = 'grid';
        $view->path_url     = $this->get_path_url(HTML::link('/grid','grid组件'));

        return $view;
    }





}