<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Cache;
use Phpstore\Crud\ImageLib;
use App\Models\AdminRole;
use Hash;
use Phpstore\Repository\AdminRepository;

class Admin extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword,AdminRepository;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'admins';

    /*
    |-------------------------------------------------------------------------------
    |
    | 批量插入白名单
    |
    |-------------------------------------------------------------------------------
    */
    protected $fillable = [
                                'username',
                                'email',
                                'phone',
                                'is_show',

    ];


    /*
    |-------------------------------------------------------------------------------
    |
    | 上传管理员头像
    |
    |-------------------------------------------------------------------------------
    */
    public function img(){

        $img                = new ImageLib();
        $img->put('file_name','user_icon');
        $img->put('dir','admin_user_icon');

        if($upload_img  = $img->upload_image()){

            //删除旧图片
            $this->delete_img();
            $this->user_icon  = $upload_img;
        }

        $this->save();
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 删除旧的管理员图片
    |
    |-------------------------------------------------------------------------------
    */
    public function delete_img(){

        if($this->user_icon){
            $delete_img         = $this->user_icon;
            @unlink(public_path().'/'.$delete_img);
        }
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 设置密码
    |
    |-------------------------------------------------------------------------------
    */
    public function password(){

        if(request()->password){

            $this->password     = Hash::make(request()->password);
            $this->save();
        }
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 更新管理员 角色模型
    |
    |-------------------------------------------------------------------------------
    */
    public function update_admin_role(){

        //清空所有管理员-角色中间表记录
        if(count($this->admin_role()->get())){

            $this->admin_role()->delete();
        }

        //如果选中了角色
        if(count(request()->role_ids)){

            foreach(request()->role_ids as $role_id){

                //创建新的管理员角色模型
                AdminRole::create(['role_id'=>$role_id,'admin_id'=>$this->id]);
            }
        }
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 一对多的关系  一个管理员在 管理员角色表中有多条记录
    |
    |-------------------------------------------------------------------------------
    */
    public function admin_role(){

        return $this->hasMany('App\Models\AdminRole','admin_id','id');
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 一对多的关系 一个管理员会分配多个订单
    |
    |-------------------------------------------------------------------------------
    */
    public function card(){

       return $this->hasMany(Models\Card::class,'admin_id','id');
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 多对多的关系  管理员和角色 多对多
    |
    |-------------------------------------------------------------------------------
    */
    public function role(){

        return $this->belongsToMany('App\Models\Role','admin_role','admin_id','role_id')->groupBy('role_id');
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 获取角色名称列表
    |
    |-------------------------------------------------------------------------------
    */
    public function role_name_string(){

        $str            = '';

        foreach($this->role()->get() as $role){

            $str        .= $role->role_name.' ';
        }

        return $str;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取管理员所有的权限
    |
    |-------------------------------------------------------------------------------
    */
    public function privi(){

        $arr    = [];

        if(Cache::has($this->key())){

            return Cache::get($this->key());
        }

        foreach($this->role()->get() as $role){

            foreach($role->privi()->get() as $privi){

                $arr[]      = $privi->privi_code;
            }
        }

        //去除重复的权限 即路由名称
        $arr    = array_unique($arr);

        Cache::put($this->key(),$arr,3600);

        return Cache::get($this->key());
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 管理员缓存编号
    |
    |-------------------------------------------------------------------------------
    */
    public function key(){

        return 'privi_list_admin_id_is'.$this->id;
    }
    

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];
}
