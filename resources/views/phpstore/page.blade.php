@extends('phpstore.layout.common')
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


@section('content')
	
    <div class="content">
    	
        <h2>phpstore搜索ajax grid模块</h2>
    	<p>分页模块</p>
        <p>{!!HTML::image('/static/img/page.png','分页类page')!!}</p>
        <p>current_page :当前页</p>
        <p>last_page :最后一页</p>
        <p>per_page:每页大小</p>
        <p>total:总记录 来源于tableData类中的输出 </p>
        <p>page类的实例输出：links（）</p>
        <p>输出一个：长度不超过13的总分页链</p>
        
        
    
    </div>
@stop