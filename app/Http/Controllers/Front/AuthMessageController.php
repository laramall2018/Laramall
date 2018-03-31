<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Phpstore\Base\Common;
use App\Models\Message;
use DB,Auth,Validator;

class AuthMessageController extends BaseController
{
    public $common;
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
        $this->list_url         = 'auth/message';
        $this->menu_tag         = 'message'; 

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
        
        
        $view                       = $this->view('user_message_list');
        $view->menu_tag             = $this->menu_tag;
        $view->breadcrumb           = $this->common->get_breadcrumb(trans('front.message_list'));
        $view->message_list         = DB::table('message')
                                        ->where('username',Auth::user('user')->username)
                                        ->paginate(20);
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
        
        $model              = new Message();
        $rules              = ['content'=>'required','type'=>'required'];

        $validator          = Validator::make($request->all(),$rules);
        if($validator->fails()){

                return $this->validator_is_fails($validator,$this->list_url);
        }

        $row                  = ['type','id_value','email','rank','content'];

        foreach($row as $item){

            $model->$item     = $request->$item;
        }
            $model->add_time  = time();
            $model->username  = Auth::user('user')->username;
            $model->front_ip  = $request->getClientIp();
            $model->status    = 0;

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
    | 编辑
    |
    |-------------------------------------------------------------------------------
    */
    public function edit($id)
    {
        

        $model                          =  Message::find($id);

        if(empty($model)){

             return $this->model_is_empty($this->list_url);

        }


        $view                           = $this->view('user_message_edit');
        $view->breadcrumb               = $this->common->get_breadcrumb(trans('front.message_list'));
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
    public function update(Request $request, $id)
    {
        
        $model                      = Message::find($request->id);

        if(empty($model)){

            return $this->model_is_empty($this->list_url);
        }

        $rules              = ['content'=>'required','type'=>'required'];

        $validator          = Validator::make($request->all(),$rules);
        if($validator->fails()){

                return $this->validator_is_fails($validator,$this->list_url);
        }

        $row                  = ['type','id_value','email','content'];

        foreach($row as $item){

            $model->$item               = $request->$item;
        }

        if(empty($request->rank)){

            $model->rank                = 1;
        }
        else{

            $model->rank                = $request->rank;
        }
            $model->add_time  = time();
            $model->username  = Auth::user('user')->username;
            $model->front_ip  = $request->getClientIp();

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
         
         $model             = Message::find($id);

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
