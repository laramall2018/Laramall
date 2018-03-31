<?php

namespace LaraStore\Presenters;
use App\Models\Tag;
use App\User;
use Auth;
use LaraStore\Presenters\PresenterTrait;

class TagPresenter{

	use PresenterTrait;
	protected $model;
	/*
    |-------------------------------------------------------------------------------
    |
    |  构造函数
    |
    |-------------------------------------------------------------------------------
    */
    public function __construct(Tag $model){

    	$this->model 		= $model;
    }
}