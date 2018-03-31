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
    	
        <h2>Centos下面安装redis相关注意事项</h2>
    	<p><a href="http://www.cnblogs.com/changsir/p/3366656.html" target="_blank">参考1</a></p>
        <p><a href="http://www.cnblogs.com/shanyou/archive/2012/07/14/2591881.html">参考2</a></p>
        <p><a href="http://redis.io/download" target="_blank">redis官方</a></p>
        <p>系统查找进程:ps aux|grep redis</p>
        <p>系统杀死进程:kill -9 进程id</p>
        
        
    
    </div>
@stop