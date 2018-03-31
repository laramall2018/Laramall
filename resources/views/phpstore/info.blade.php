@extends('phpstore.layout.common-info')
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

	
    <div class="portlet purple box">
    	
        <div class="portlet-title">
        	<div class="caption">
        		<i class="fa fa-cogs"></i>
            	信息提示
        	</div><!--/caption-->
        </div><!--/title-->
        
        <div class="portlet-body">
         	<div class="alert alert-success">
            	{!!$info!!}
            </div>
            <div class="alert alert-info">
            	<span id="totalSecond" class="red">3</span>秒自动返回上一页
            </div>
            <div class="alert alert-info">
            	{!!$url!!}
            </div>
        </div><!--/body-->
    	
    </div><!--/portlet-->   
@stop