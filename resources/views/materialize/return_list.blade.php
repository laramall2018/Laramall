@extends('materialize.layout.common')
@section('title')
{!!$title!!}
@stop

@section('content')
	@include('materialize.lib.breadcrumb')
	<div class="row">
	<div class="col s12">
	<div class="card-panel">
	
	<a href="{!!$back_url!!}" class="btn">返回</a>
  <a href="{!!url('auth/mobile/return/create')!!}" class="btn red">申请退货</a>

	<ul class="collection">

	@foreach($user->order_return()->orderBy('id','desc')->get() as $item)
    <li class="collection-item avatar">
      
     
	  <a href="{!!url('auth/mobile/return/'.$item->id)!!}">
      <i class="material-icons circle green">insert_chart</i>
      </a>
      
      <span class="title">
      	编号:
      	<a href="{!!url('auth/mobile/return/'.$item->id)!!}">{!!$item->order->order_sn!!}</a>
      </span>
      <p>
          金额:
          <strong class="red-text">￥{!!$item->return_amount!!}</strong><br>
          状态:
          <strong class="red-text">{{$item->status()}}</strong><br>
          时间:{!!$item->time()!!}
      </p>
      
    </li>
	@endforeach
    </ul>


	</div>
	</div>
	</div>
@stop