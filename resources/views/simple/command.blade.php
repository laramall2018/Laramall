@extends('simple.layout.common')
@section('title')
{!!$title!!}
@stop

@section('script')
{!!HTML::script('files/jquery.validate.min.js')!!}
{!!HTML::style('static/icheck/skins/all.css')!!}
{!!HTML::script('static/icheck/icheck.js')!!}
{!!HTML::script('files/bootstrap/js/bootstrap.min.js')!!}
{!!$form_validate_url!!}
{!!$crud_js!!}
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


@section('content')
	
    
    <div class="content-box">
    	
         {!!$path_url!!}
         <div class="panel panel-success">
         	<div class="panel-heading">
            	命令行批量添加商品信息
            </div>
            <div class="panel-body">
            	
                <div class="alert alert-info">【1】先编辑Install/Common.php中的函数get_goods_list 添加商品数据</div>
                <div class="alert alert-info">【2】终端下启用命令行：php mywebphp phpstore:insert</div>
    			<h5>数组格式如下</h5>
                <img src="{!!url('files/images/array.png')!!}" class="img-thumbnail" />
                <h5>命令行导入10万条记录</h5>
                <img src="{!!url('files/images/command1.png')!!}" class="img-thumbnail" />
                <img src="{!!url('files/images/command2.png')!!}" class="img-thumbnail" />
            
            </div><!--/panel-body-->
         </div>
    </div>
@stop