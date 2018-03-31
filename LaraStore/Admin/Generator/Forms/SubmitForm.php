<?php

namespace LaraStore\Admin\Generator\Forms;

use Form; 

class SubmitForm extends TypeForm{

	
	/*
    |-------------------------------------------------------------------------------
    |
    | 返回参数
    |
    |-------------------------------------------------------------------------------
    */
    public function make(){

    	  return '<div class="form-actions fluid">'
               .'<div class="col-md-offset-3 col-md-9">'
               .'<input type="submit" class="btn btn-success" id="'.$this->id.'" value="'.$this->value.'">'
               .'&nbsp;&nbsp;<a href="'.$this->back_url.'" class="btn btn-danger">返回</a>'
               .'</div>'
               .'</div>';

    }

}