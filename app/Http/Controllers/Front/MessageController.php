<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Phpstore\Base\Common;
use DB;
use App\Models\Message;
use App\User;
use Validator;

class MessageController extends BaseController
{
    
    public $common;
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {

            parent::__construct();
            
            $this->common          = new Common();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 首页显示控制器
    |
    |-------------------------------------------------------------------------------
    */
    public function index(){


        $view                   = $this->view('message');
        $view->breadcrumb       = $this->common->get_breadcrumb(trans('front.user_message'));
        $view->messages         = Message::canShowList();


        return $view;


    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 显示留言版的form
    |
    |-------------------------------------------------------------------------------
    */
    public function form(){

        $view                   = $this->view('message_form');

        return $view;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 存储留言到数据库
    |
    |-------------------------------------------------------------------------------
    */
    public function store(Request $request){

        $model                 = new Message();

        $rules                 = [
                                    'username'      =>'required',
                                    'content'       =>'required',
                                    'email'         =>'required|email',
                                    'type'          =>'required'

        ];

        $validator             = Validator::make($request->all(),$rules);

        if($validator->fails()){

            $view              = $this->view('message_validator');
            $view->messages    = $validator->messages();
            $view->back_url    = url('message-form');

            return $view;
        }


        $row                   = ['username','email','content','type'];

        foreach($row as $item){

            $model->$item      = $request->$item;
        }
            $model->add_time   = time();
            $model->front_ip   = $request->getClientIp();
            $model->parent_id  = 0;
            $model->status     = 0;

        if($model->save()){

            $view              = $this->view('message_info');
            $view->info        = trans('front.message_add_success');
            $view->back_url    = url('message');

            return $view;
        }

    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取系统的留言板列表
    |
    |-------------------------------------------------------------------------------
    */
    public function get_message(){

        $row                            = Message::where('status',1)
                                                 ->orderBy('id','desc')
                                                 ->paginate(20);

        foreach($row as $value){

            $value['add_time_str']      = date('Y/m/d',$value->add_time);
            $value['user']              = $this->get_user_info($value->username);
        }

        return $row;
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 获取用户信息
    |
    |-------------------------------------------------------------------------------
    */
    public function get_user_info($username){


        $row            = User::where('username',$username)->first();

        if($row){

            return $row;
        }

        return false;
    }



}
