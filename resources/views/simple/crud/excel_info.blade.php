@extends('simple.layout.common')
@section('title')
{!!$title!!}
@stop

@section('description')
{!!$description!!}
@stop

@section('keywords')
{!!$keywords!!}
@stop

@section('appname')
{!!$appname!!}
@stop

@section('script')
{!!HTML::style('static/icheck/skins/all.css')!!}
{!!HTML::script('static/icheck/icheck.js')!!}
{!!HTML::script('files/bootstrap/js/bootstrap.min.js')!!}
{!!HTML::script('files/jquery.confirm.js')!!}
{!!HTML::script('static/js/jquery.json-2.4.js')!!}
{!!HTML::script('static/js/phpstore.grid.js')!!}
@stop


@section('content')

<div class="content-box">

	<div class="row">
    	<div class="col-md-12">
        	{!!$path_url!!}
        </div>
    </div>
    
    <div class="alert alert-success">
    	<span>{!!$excel_name!!}已生成</span>
    </div><!--/alert-info-->
    <div class="alert alert-info">
    
    	<a href="{!!url($excel_name)!!}" class="btn btn-success">
        	<span class="glyphicon glyphicon-download"></span>
        	下载excel文件
        </a>
    	<a href="{!!url('admin/excel')!!}" class="btn btn-primary">
        	<span class="glyphicon glyphicon-arrow-left"></span>
            返回
        </a>
    </div>
</div>
   
@stop

