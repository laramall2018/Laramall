<?php namespace Phpstore\Crud;


use HTML;
use DB;
use Form;
use App\Models\Region;
use App\Models\Privi;



/*
|-------------------------------------------------------------------------------
|
| 构造函数
|
|-------------------------------------------------------------------------------
*/
class FormHelp{

	protected  $row;                         //用于填充表单的数组数据
	protected  $type;  						 //表单的类型
	protected  $field; 				 		 //表单里面的字段名称
	protected  $name;						 //表单的中文名称
	protected  $value;						 //表单的值
	

	/*
    |-------------------------------------------------------------------------------
    |
    | 构造函数
    |
    |-------------------------------------------------------------------------------
    */
    function __construct(){


    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  给对象属性赋值
    |
    |-------------------------------------------------------------------------------
    */
    public function put($key,$value){

        $this->$key             = $value;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  生成带portlet的dom元素 
    |  $html_string  填充的html元素
    |  $color        portl
    |
    |-------------------------------------------------------------------------------
    */
    public function portlet(){

        $str    = '<div class="portlet box '.$this->color.'">'
                 .'<div class="portlet-title">'
                 .'<div class="caption">'
                 .$this->title 
                 .'</div>'
                 .'<div class="tools">'
                 .'<a href="javascript:;" class="collapse"></a>'
                 .'<a href="javascript:;" class="reload"></a>'
                 .'</div>'
                 .'</div>'
                 .'<div class="portlet-body">'
                 .$this->content 
                 .'</div>'
                 .'</div>';

        return $str;

    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  生成table数据
    |
    |-------------------------------------------------------------------------------
    */
    public function table(){

        $str   = '<div class="table-scrollable">'
                 .'<table class="table table-striped table-bordered table-hover">'
                 .'<thead>'
                 .'<tr>';

        if(empty($this->col)){

            return '';
        }


             
        foreach($this->col as $th){

              $str .= '<th scope="col">'.$th.'</th>';
        }

              $str .='</tr></thead>';
              $str .='</tbody>';

        if(empty($this->data)){

              return '';
        }

              
        foreach($this->data as $value){
            
            $str .= '<tr>'
                   .'<td><input type="radio" class="icheck mycheckbox" name="table" value="'
                   .$value['field']
                   .'">'
                   .$value['field']
                   .'</td>'
                   .'<td>'.$value['name'].'</td>'
                   .'<td>'.$value['info'].'</td>'
                   .'</tr>';
           
        }
              
              $str .='</tbody></table></div>';


        return $str;
    }   


}