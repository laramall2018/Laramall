@extends('matrix.layout.common')
@section('title')
{!!$title!!}
@stop

@section('content')
	
	@include('matrix.lib.breadcrumb')
	
	<div class="container">
	<div class="alert alert-success">
		<p>批量下单格式：商品名称 + 空格 + 属性（必须填写 属性没有 可以写：无) + 空格 + 数量(必须填写)</p>
		<p>例如：<span class="org">花汐棕 0/0 2</span> 
		  代表：购买商品名称为：<span class="org">花汐棕</span> 属性:<span class="org">0/0</span>
		  数量：<span class="org">2</span>
		</p>
		<p>最后一行为客户信息：<span class="org">姓名</span> + 空格 + <span class="org">电话</span>
		+ 空格 + <span class="org">地址</span>
		</p>
		<p>比如：<span class="org">码农风清扬</span>  <span class="org">13800000000</span> <span class="org">中国陕西华山之巅</span>
		<p>地址信息必须写在一行</p>
		<p>可以同时写多行商品信息</p>
		<p>每个订单之间使用一个或者多个#号来间隔开来</p>

	</div>
	
	{!!Form::open(['url'=>'auth/batch-order','method'=>'post','class'=>'form-horizontal'])!!}
	
	<div class="form-group">
    
     <div class="col-md-12">
      <h4>请输入批量下单信息</h4>
      <textarea id="order" name="order" class="form-control" rows="20">{{old('order')}}</textarea>
     </div>
    </div>

    @if(count($errors))
    @foreach($errors as $error)
    <div class="form-group">
    	<div class="col-md-12">
			<p class="org">{{$error}}</p>
    	</div>
    </div>
    @endforeach
    @endif
	
	@if(session()->has('info'))
    <div class="form-group">
    	<div class="col-md-12">
			<p class="org">{{session()->get('info')}}</p>
    	</div>
    </div>
    @endif

    <div class="form-group">
    <div class="col-md-12">
    	<button type="submit" class="btn btn-success btn-lg">
			<i class="fa fa-check"></i>
			确认下单
    	</button>
    </div>
    </div>
	{!!Form::close()!!}
	
	</div><!--/container-->
@stop