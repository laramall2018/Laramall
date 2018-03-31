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
				<th>姓名</th>
				<td>{{$model->username}}</td>
			</tr>
			<tr>
				<th>类型</th>
				<td>{{$model->type()}}</td>
			</tr>
			<tr>
				<th>金额</th>
				<td><strong class="red-text">￥{{$model->amount}}</strong></td>
			</tr>
			<tr>
				<th>支付方式</th>
				<td>{{$model->payment}}</td>
			</tr>
			<tr>
				<th>状态</th>
				<td>{{$model->pay_tag()}}</td>
			</tr>
			<tr>
				<th>申请时间</th>
				<td>{{$model->time()}}</td>
			</tr>
			<tr>
				<th>ip</th>
				<td>{{$model->ip}}</td>
			</tr>
			<tr>
				<th>用户备注</th>
				<td>{{$model->user_note}}</td>
			</tr>
			<tr>
				<th>管理员</th>
				<td>{{$model->admin}}</td>
			</tr>
			<tr>
				<th>管理备注</th>
				<td>{{$model->admin_note}}</td>
			</tr>
	</table>
</div>
</div>
</div>

@stop