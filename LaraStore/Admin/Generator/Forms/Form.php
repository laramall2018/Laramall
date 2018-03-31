<?php

namespace LaraStore\Admin\Generator\Forms;

use LaraStore\Admin\Generator\Forms\{
        TextForm,
        SelectForm
};


class Form{

	protected $attributes = [];
	protected $type;
	protected $field;
	protected $name;
	protected $id;
	protected $value;
	protected $render = '';
	/*
    |-------------------------------------------------------------------------------
    |
    | 构造函数
    |
    |-------------------------------------------------------------------------------
    */
    public function __construct(){

       

    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 设置参数
    |
    |-------------------------------------------------------------------------------
    */
    public function put($key,$value){

    	$this->$key 		= $value;
    	return $this;
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 检测表单的类型是否符合要求
    |
    |-------------------------------------------------------------------------------
    */
    public function check($type){

        if(in_array($type,$this->types())){

            return true;
        }

        return false;
    }


    

    /*
    |-------------------------------------------------------------------------------
    |
    | 获取参数
    |
    |-------------------------------------------------------------------------------
    */
    public function get($key){

    	return $this->$key;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  根据type返回不同的类
    |
    |-------------------------------------------------------------------------------
    */
    public function formAction($attribute){

            if($this->check($attribute['type'])){

                $typeForm       = 'LaraStore\\Admin\\Generator\\Forms\\'.ucfirst($attribute['type']).'Form';
                return new $typeForm($attribute);
            }

            return false;
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |   循环生成表单数据
    |
    |-------------------------------------------------------------------------------
    */
    public function render(){

    	$str 		= '';
    	foreach($this->attributes as $attribute){
             
             if($this->formAction($attribute)){

                $str  .= $this->formAction($attribute)->handle();
             }
    		 
    	}

    	return $str;
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |   返回表单数据
    |
    |-------------------------------------------------------------------------------
    */
    public function handle(){

    	return $this->makeForm();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 返回所有表单的类型字段数组
    |
    |-------------------------------------------------------------------------------
    */
    public function types(){

        return [
                    'text',
                    'select',
                    'radio',
                    'checkbox',
                    'file',
                    'hidden',
                    'submit',
                    'textarea',
                    'ueditor',
        ];
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   返回表单字符串
    |
    |-------------------------------------------------------------------------------
    */
    public function makeForm(){

    	return    '<form method="'.$this->method.'" action="'.url($this->url).'" class="form-horizontal">'
    			  .'<input type="hidden" name="_token" value="'.csrf_token().'">'
    			  .$this->render()
    			  .'</form>';

    }
}