@extends('materialize.layout.common')
@section('title')
{!!$title!!}
@stop

@section('content')
	@include('materialize.lib.breadcrumb')
	<div class="row">
	<div class="col s12">
	<div class="card-panel">
	
	<ul class="collection">	
	@foreach($user->address()->get() as $address)
	<li class="collection-item">
		{!!$address->address()!!}-{!!$address->consignee!!}
	</li>	
	@endforeach
	</ul>

	<a href="{!!url('mobile/address/create')!!}" class="btn red">添加地址</a>

	</div>
	</div>
	</div>
@stop



