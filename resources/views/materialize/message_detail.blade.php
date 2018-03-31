@extends('materialize.layout.common')
@section('title')
{!!$title!!}
@stop

@section('content')
@include('materialize.lib.breadcrumb')
<div class="row">
<div class="col s12">
<a href="{{$back_url}}" class="btn offset-top10">返回</a>
<div class="card-panel">
	
	<table class="table bordered striped">
		<tr>
			<th>类型</th>
			<td>{{$model->type}}</td>
		</tr>
		<tr>
			<th>电邮</th>
			<td>{{$model->email}}</td>
		</tr>
		@if($model->goods)
		<tr>
			<th>商品</th>
			<td>
			<a href="{{$model->goods->url()}}">{{$model->goods->goods_name}}</a>
			</td>
		</tr>
		@endif

		<tr>
			<th>等级</th>
			<td>{{$model->rank}}</td>
		</tr>
		<tr>
			<th>状态</th>
			<td>{{$model->status()}}</td>
		</tr>
		<tr>
			<th>内容</th>
			<td>{{$model->content}}</td>
		</tr>
		<tr>
			<th>添加ip</th>
			<td>{{$model->front_ip}}</td>
		</tr>
		<tr>
			<th>时间</th>
			<td>{{$model->time()}}</td>
		</tr>
		@if($model->reply)
		<tr>
			<th><strong class="red-text">管理员回复</strong></th>
			<td><strong class="red-text">{{$model->reply}}</strong></td>
		</tr>
		<tr>
			<th><strong class="red-text">回复时间</strong></th>
			<td><strong class="red-text">{{$model->reply_time()}}</strong></td>
		</tr>
		@endif
	</table>

</div>
</div>
</div>
@stop