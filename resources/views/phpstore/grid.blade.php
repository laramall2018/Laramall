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
    	<p>系统ajax搜索排序分页显示表格grid组件 有三个组件组成</p>
        <p>{!!HTML::image('/static/img/grid.png','grid类')!!}</p>
        <p>grid类只有一个属性 也就是tabledata的实例</p>
        <p>grid输出：显示表格的初始化值</p>
        <p>grid输出：render（） json格式给javascript用来重新刷新页面</p>
        
        
    
    </div>
@stop