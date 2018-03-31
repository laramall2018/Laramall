<?php

namespace LaraStore\Crud\Common\Form;

use LaraStore\Admin\Generator\Forms\Form as AdminGeneratorForm;
use LaraStore\Crud\Common\Form\FormTrait;


class CreateForm{

    use FormTrait;

    protected $url;
    protected $method = 'post';
    protected $data;
    /*
    |-------------------------------------------------------------------------------
    |
    |   构造函数
    |
    |-------------------------------------------------------------------------------
    */
    public function __construct($model){

        $this->form          = new AdminGeneratorForm();
        $this->attributes    = call_user_func([$model,'createData']);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   生成表单
    |
    |-------------------------------------------------------------------------------
    */
    public function make(){
        
        return $this->form->put('url',$this->url)
                          ->put('method',$this->method)
                          ->put('attributes',$this->attributes)
                          ->handle();
    }
}