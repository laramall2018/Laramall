<?php namespace Phpstore\Log;

use Phpstore\Grid\TableData;
use Phpstore\Grid\Grid;
use Phpstore\Grid\Page;
use Phpstore\Grid\Common;
use Phpstore\Base\Goodslib;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Goods;
use App\Models\Attribute;
use App\Models\GoodsAttr;
use App\Models\Log;
use App\Models\Privi;
use Request;
use Auth;



  class Mylog{


      public $log_info;
      public $add_time;
      public $user_id;

      /*
      |-------------------------------------------------------------------------------
      |
      | 构造函数
      |
      |-------------------------------------------------------------------------------
      */
      public function __construct(){


         if(Auth::check()){

             $this->user_id       = Auth::user()->id;
         }
         else{

              $this->user_id      = 0;
         }


      }



      /*
      |-------------------------------------------------------------------------------
      |
      | 给对象属性赋值
      |
      |-------------------------------------------------------------------------------
      */
      public function put($key,$value){


          $this->$key     = $value;

      }

      /*
      |-------------------------------------------------------------------------------
      |
      | 获取属性的值
      |
      |-------------------------------------------------------------------------------
      */
      public function get($key){


        if(property_exists($this, $key)){

           return $this->$key;
        }

          return '';

      }

      /*
      |-------------------------------------------------------------------------------
      |
      | 存储日志到数据库表中
      |
      |-------------------------------------------------------------------------------
      */
      public function  log(){

          $row      = [
                          'admin.log.index',
                          'admin.log.delete',
                          'admin.log.grid',
                          'admin.log.batch'

                      ];

          //如果是对日志文件进行操作 则不需要记录
          if(in_array($this->route_name,$row)){

               return false;
          }

          $log                 = new Log();
          $log->log_info       = $this->get_log_info($this->route_name);
          $log->user_id        = $this->user_id;
          $log->ip             = Request::getClientIp();
          $log->add_time       = time();
          $log->sort_order     = 0;
          $log->save();
      }


      /*
      |-------------------------------------------------------------------------------
      |
      | 获取日志操作名称
      |
      |-------------------------------------------------------------------------------
      */
      public function get_log_info($route_name){

           $privi       = Privi::where('privi_code',$route_name)->first();

           if(empty($privi)){

               return '';
           }

            return $privi->privi_name;
      }




  }
