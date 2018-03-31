<?php namespace Phpstore\Base;

use HTML;
use Auth;
use Phpstore\Base\Sysinfo;
use DB;
use App\Models\Privi;
use App\Models\Role;
use App\Models\RolePrivi;
use App\User;
use App\Admin;
use URL;
use Config;
use App;
use mysqli;
use Cache;

class Base{

    protected $title;
    protected $admin_login_url;
    protected $forbidden_info;



    /*
    |-------------------------------------------------------------------------
    |
    | 构造函数
    |
    |-------------------------------------------------------------------------
    */
    function __construct(){

        $this->admin_login_url      = env('ADMIN_LOGIN_URL');
        $this->forbidden_info       = '您未授权访问此链接';


    }


    /*
    |-------------------------------------------------------------------------
    |
    | 验证是否是后台用户
    |
    |-------------------------------------------------------------------------
    */
    public function is_admin(){

        if(Auth::check('admin')){
            return true;
        }

        return false;
    }


    /*
    |-------------------------------------------------------------------------
    |
    |  检测当前访问的路由名称是否已经被授权 privi_code == route_name
    |
    |-------------------------------------------------------------------------
    */
    public function check_admin_privi($privi_code , $request){

           //登录链接 可以绕过权限认证
           if($request->is(env('ADMIN_LOGIN_URL'))){

                return true;
           }

           //信息提示页面 也可以绕过权限认证
           if($request->is("admin/info")){

               return true;
           }

           //如果没有登录
           if(!Auth::check('admin')){

                return false;

           }
           //当前登录管理员
           $admin     = Auth::user('admin');

           //当前管理员权限为空
           if(count($admin->privi()) == 0){

                return false;
           }
           

           if(in_array($privi_code ,$admin->privi())){

                return true;
           }

           return false;
    }


    /*
    |-------------------------------------------------------------------------
    |
    |  获取当前角色的权限代码数组 从缓存中获取
    |
    |-------------------------------------------------------------------------
    */
    public function get_role_privi_list_from_cache($role_id){

           $key         = 'role_privi_list_'.$role_id;

           if(Cache::has($key)){

                 return Cache::get($key);
           }
           else{

                 $role_privi_list     = $this->get_role_privi_list($role_id);
                 Cache::put($key , $role_privi_list , 3600);
                 return Cache::get($key);
           }
    }

    /*
    |-------------------------------------------------------------------------
    |
    |  获取当前角色的权限代码数组 
    |  
    |  role        ---------------- 角色表
    |  role_privi  ---------------- 角色权限表
    |  privi       ---------------- 权限表
    |
    |-------------------------------------------------------------------------
    */
    public function get_role_privi_list($role_id){

         $res               = DB::table('privi as p')
                                ->leftjoin('role_privi as rp','rp.privi_id','=','p.id')
                                ->where('rp.role_id','=',$role_id)
                                ->select('p.privi_code')
                                ->get();
         $arr               = [];

         foreach($res as $item){

            $arr[]          = $item->privi_code;
         }

         return $arr;
    }

    /*
    |-------------------------------------------------------------------------
    |
    |  获取授权代码
    |
    |-------------------------------------------------------------------------
    */
    public function get_privi_code($privi_id){

        $privi              = Privi::find($privi_id);

        if(empty($privi)){

            return '';
        }

        return $privi->privi_code;
    }

    /*
    |-------------------------------------------------------------------------
    |
    |  获取授权路由
    |
    |-------------------------------------------------------------------------
    */
    public function get_privi_route($privi_id){

        $privi              = Privi::find($privi_id);

        if(empty($privi)){

            return '';
        }

        return $privi->privi_route;
    }


    /*
    |-------------------------------------------------------------------------
    |
    | 判断用户登录 返回信息提示页面
    |
    |-------------------------------------------------------------------------
    */
    public function PriviSysinfo($privi_code){

        //如果用户已经登录 跳转到信息提示页面
        if(Auth::check('admin')){

            return redirect(env('ADMIN_INFO_URL'));
        }

        //返回登录页面
        return redirect(env('ADMIN_LOGIN_URL'));

    }



    /*
    |-------------------------------------------------------------------------
    |
    |  后台用户已登录 但是未获取访问授权 则提示禁止访问信息
    |
    |-------------------------------------------------------------------------
    */
    public function forbidden(){

        $sysinfo                = new Sysinfo();
        $sysinfo->put('info',$this->forbidden_info);
        $sysinfo->put('url',url('admin/index'));
        $sysinfo->put('page','');
        $sysinfo->put('tag','');
        return $sysinfo->info();

    }


    /*
    |-------------------------------------------------------------------------
    |
    |   获取系统的配置信息
    |
    |-------------------------------------------------------------------------
    */
    public function get_system_info(){

        $row                            = [];
        $row['version']                 = App::version();
        $row['timezone']                = Config::get('app.timezone');
        $row['os']                      = PHP_OS;
        $row['phpversion']              = phpversion();

        $row['web_server']              = $_SERVER['SERVER_SOFTWARE'];
        $row['mysql']                   = $this->get_mysql_version();
        $row['appname']                 = 'phpstore b2b2c旗舰版';
        $row['safe_mode']               = (boolean) ini_get('safe_mode') ?  '是':'否';
        $row['created_at']              = Admin::first()->pluck('created_at');
        $row['upload_max_filesize']     = ini_get("upload_max_filesize");

        return $row;
    }


    /*
    |-------------------------------------------------------------------------
    |
    |   获取mysql的版本信息
    |
    |-------------------------------------------------------------------------
    */
    public function get_mysql_version(){

        $host           =  env('DB_HOST');
        $database       =  env('DB_DATABASE');
        $username       =  env('DB_USERNAME');
        $password       =  env('DB_PASSWORD');

        $mysqli = new mysqli($host, $username, $password);

        return $mysqli->server_info;
    }


    /**
     * 获取系统分类菜单树
     *
     * @var array
     *
     */
    public function category_tree(){

        $row          = [];
        $cat_one      = DB::table('category')->where('parent_id',0)->get();

        //获取一个包含了一级分类的一维数组
        foreach($cat_one as $item){

              $row[]      = [

                                'id'=>$item->id,
                                'cat_name'=>$item->cat_name,
                                'parent_id'=>0,
                                'sort_order'=>$item->sort_order,
                                'level'=>1

              ];
        }

        //获取每个一级分类的二级分类子结点
        foreach($row as $key=>$value){

              $row[$key]['son'] = $this->get_child($value['id'],$value['level']);

              //三级分类子结点
              $arr  = $row[$key]['son'];

              foreach($arr as $k=>$v){

                 $row[$key]['son'][$k]['son']  = $this->get_child($v['id'],$v['level']);
              }

        }


        return $row;

    }



    /**
     * 获取当前结点下的子结点
     *
     * @var array
     *
     */
    public function get_child($id,$level){

          $row            = DB::table('category')->where('parent_id',$id)->get();
          $arr            = [];

          foreach($row as $key=>$value){

                $arr[]      = [

                                  'id'=>$value->id,
                                  'cat_name'=>$value->cat_name,
                                  'parent_id'=>$id,
                                  'sort_order'=>$value->sort_order,
                                  'level'=>$level + 1
                ];
          }

        return $arr;
    }




}
