<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Phpstore\Base\Common;
use App\Models\Tag;
use DB,Auth,Validator;

class AuthTagController extends BaseController
{
    public $common;
    public $login_url;
    public $list_url;
    public $menu_tag;


    /*
    |-------------------------------------------------------------------------------
    |
    | 构造函数
    |
    |-------------------------------------------------------------------------------
    */
    public function __construct()
    {
        parent::__construct();
        
        $this->common           = new Common();
        $this->list_url         = 'auth/tag';
        $this->menu_tag         = 'tag'; 

        //中间件 检测用户是否为前台登录用户
        $this->middleware('front.auth');

    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 显示所有地址列表
    |
    |-------------------------------------------------------------------------------
    */
    public function index()
    {
        
        
        $view                       = $this->view('user_tag_list');
        $view->menu_tag             = $this->menu_tag;
        $view->breadcrumb           = $this->common->get_breadcrumb(trans('front.tag_list'));
        $view->tag_list             = $this->common->get_user_tag_list(Auth::user('user')->username);
        $view->goods_list           = DB::table('goods')->get();
        $view->user                 = Auth::user('user');
        
        return $view;

    }  

    

    /*
    |-------------------------------------------------------------------------------
    |
    | 存储表单数据到数据库
    |
    |-------------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        
        $model              = new Tag();
        $rules              = [
                                'tag_name'         =>'required|unique:tag,tag_name',
                                'goods_id'         =>'required',
                                
        ];

        $validator          = Validator::make($request->all(),$rules);
        if($validator->fails()){

                return $this->validator_is_fails($validator,$this->list_url);
        }

        $row                  = ['tag_name','goods_id','sort_order'];

        foreach($row as $item){

            $model->$item     = $request->$item;
        }
            $model->add_time  = time();
            $model->username  = Auth::user('user')->username;

        if($model->save()){

            return redirect($this->list_url);
        }
        else{

            return $this->store_or_update_is_fails($this->list_url);
        }
    }

    


    /*
    |-------------------------------------------------------------------------------
    |
    | 编辑的时候 传递id值后 自动把model传递过来了
    |
    |-------------------------------------------------------------------------------
    */
    public function edit($id)
    {
        
        $model          = Tag::find($id);

        if(empty($model)){

             return $this->model_is_empty($this->list_url);

        }


        $view                           = $this->view('user_tag_edit');
        $view->breadcrumb               = $this->common->get_breadcrumb(trans('front.tag_list'));
        $view->menu_tag                 = $this->menu_tag;
        $view->model                    = $model;
        $view->goods_list               = DB::table('goods')->get();
        $view->back_url                 = url($this->list_url);
        return $view;

    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 更新数据库记录
    |
    |-------------------------------------------------------------------------------
    */
    public function update(Request $request)
    {
        
        $id                 = $request->id;
        $model              = Tag::find($id);
        if(empty($model)){

            return $this->model_is_empty($this->list_url);
        }

        $rules              = [
                                'tag_name'         =>'required|unique:tag,tag_name,'.$id,
                                'goods_id'         =>'required',
        ];

        $validator          = Validator::make($request->all(),$rules);
        if($validator->fails()){

                return $this->validator_is_fails($validator,$this->list_url);
        }

        $row                  = ['tag_name','goods_id','sort_order'];

        foreach($row as $item){

            $model->$item               = $request->$item;
        }
            $model->add_time            = time();
            $model->username            = Auth::user('user')->username;

        if($model->save()){

            return redirect($this->list_url);
        }
        else{

            return $this->store_or_update_is_fails($this->list_url);
        }

    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 删除记录
    |
    |-------------------------------------------------------------------------------
    */
    public function destroy($id)
    {
         
         $model             = Tag::find($id);

         if(empty($model)){

                return $this->model_is_empty($this->list_url);
         }

         if($model->delete()){

            return redirect($this->list_url);
         }
         else{

            return $this->operate_database_is_fails($this->list_url);
         }
    }

}
