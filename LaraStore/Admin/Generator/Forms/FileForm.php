<?php

namespace LaraStore\Admin\Generator\Forms;

use Form; 

class FileForm extends TypeForm{

	
	/*
    |-------------------------------------------------------------------------------
    |
    | 返回参数
    |
    |-------------------------------------------------------------------------------
    */
    public function make(){

    	$str  = '<div class="form-group">'
               .Form::label($this->field , $this->name , ['class'=>'col-md-3 control-label'])
               .'<div class="col-md-4">'
               .'<div class="file-offset">'
               .'<input type="file" name="'.$this->field.'" id="'.$this->id.'">'
               .'<span>'.$this->file_info.'</span>'
               .'</div>'
               .'</div>'
               .'</div>';

        if($this->upload_img){

               $str .= '<div class="form-group">'
                    .'<div class="col-md-9 col-md-offset-3">'
                    . HTML::image($this->upload_img,'',['class'=>'img-thumbnail config-img'])
                    .'</div>'
                    .'</div>';
        }

        return $str;
    }

}