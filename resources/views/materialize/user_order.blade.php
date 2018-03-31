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

	<ul class="collection">

	@foreach($user->order()->orderBy('id','desc')->paginate(20) as $order)
    <li class="collection-item avatar">
      @if($order->goods()->first())
      <a href="{!!url('auth/mobile/order/'.$order->id)!!}">
      <img src="{!!url($order->goods()->first()->gallery()->first()->thumb())!!}" class="circle">
      </a>
      @else
	  <a href="{!!url('auth/mobile/order/'.$order->id)!!}">
      <i class="material-icons circle green">insert_chart</i>
      </a>
      @endif
      <span class="title">
      	编号:
      	<a href="{!!url('auth/mobile/order/'.$order->id)!!}">{!!$order->order_sn!!}</a>
      </span>
      <p>
          金额:
          <strong class="red-text">￥{!!$order->order_amount!!}</strong><br>
          状态:
          <strong class="red-text">{{$order->status()}}</strong><br>
          时间:{!!$order->time()!!}
      </p>
      
    </li>
	@endforeach
    </ul>

    {!!$user->order()->orderBy('id','desc')->paginate(20)->render()!!}

	</div>
	</div>
	</div>
@stop