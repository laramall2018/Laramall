@extends('matrix.layout.common')
@section('title')
{!!$title!!}
@stop

@section('content')
<link href="{!!url('front/matrix/animate.css')!!}" rel="stylesheet" type="text/css" />
<link href="{!!url('static/icheck/skins/all.css')!!}" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{!!url('static/icheck/icheck.js')!!}"></script>
	
	@include('matrix.lib.breadcrumb')
	
	<div class="container">
	<div class="alert alert-success">
		<p>批量下单格式：商品名称 + 空格 + 属性（属性没有 可以写：无) + 空格 + 数量(数量默认为1 可以不写</p>
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

	</div>
	
	{!!Form::open(['url'=>'auth/batch-order-done','method'=>'post','class'=>'form-horizontal'])!!}
	
	<div class="form-group">
    
     <div class="col-md-12">
      <h4>请核对您批量下单的信息</h4>
     </div>
    </div>

    @foreach($data as $key=>$order)
    <div class="alert alert-info">
    	<input type="checkbox" name="keys[]" value="{{$key}}" checked="checked" class="mycheckbox">
    	订单{{$key + 1}}
    </div>
    @foreach($order['goods'] as $item)
	<div class="form-group">
		<div class="col-md-12">
		    <label for="goods_ids{{$key}}" class="col-md-1 control-label">商品名称</label>
			<div class="col-md-3">
				<select name="goods_ids{{$key}}[]" id="goods_ids{{$key}}" class="form-control">
					@if($item['goods'])
					@foreach($item['goods'] as $value)
					<option value="{{$value->id}}">{{$value->goods_name}}</option>
					@endforeach
					@endif
				</select>
			</div>

			<label for="goods_attrs" class="col-md-1 control-label">商品属性</label>
			<div class="col-md-3">
				<input type="text" name="goods_attrs{{$key}}[]" id="goods_attrs" class="form-control" value="{{$item['goods_attr']}}">
			</div>

			<label for="goods_numbers" class="col-md-1 control-label">购买数量</label>
			<div class="col-md-3">
				<input type="text" name="goods_numbers{{$key}}[]" id="goods_numbers" class="form-control" value="{{$item['goods_number']}}">
			</div>
			
		</div>
	</div>
	@endforeach

	@if($order['address'])
	<div class="form-group">
		<div class="col-md-12">
		    <label for="consignee" class="col-md-1 control-label">收货人姓名</label>
			<div class="col-md-3">
				<input type="text" name="consignee{{$key}}" id="consignee" class="form-control" value="{{$order['address']['consignee']}}">
			</div>

			<label for="phone" class="col-md-1 control-label">电话/手机</label>
			<div class="col-md-3">
				<input type="text" name="phone{{$key}}" id="phone" class="form-control" value="{{$order['address']['phone']}}">
			</div>

			<label for="address" class="col-md-1 control-label">地址信息</label>
			<div class="col-md-3">
				<input type="text" name="address{{$key}}" id="address" class="form-control" value="{{$order['address']['address']}}">
			</div>
		</div>
	</div>
	@endif

	@endforeach
	
	@if(session()->has('info'))
	<div class="form-group">
		<div class="col-md-12">
			<div class="alert alert-danger">
				<i class="fa fa-times"></i>
				{{session()->get('info')}}
			</div>
		</div>
	</div>
	@endif
    
	<input type="hidden" name="total" value="{{$total}}">
    <div class="form-group">
    <div class="col-md-12">
    	<button type="submit" class="btn btn-success btn-lg" id="submit-btn-span">
			<i class="fa fa-check"></i>
			确认下单
    	</button>
    	<a href="{{url('auth/batch-order')}}" class="btn btn-danger btn-lg">
			<i class="fa fa-back"></i>
			返回
    	</a>
    </div>
    </div>
	{!!Form::close()!!}
	
	</div><!--/container-->

	<script type="text/javascript">
	$(function(){
		front.icheckbox();
	})
   </script>
@stop