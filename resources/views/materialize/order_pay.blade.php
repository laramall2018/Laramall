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
    {!!Form::open(['url'=>'auth/mobile/order','method'=>'post'])!!}
    <p>订单编号:{{$order->order_sn}}</p>
    <p>订单总金额:<strong class="red-text">￥{{$order->order_amount}}</strong></p>
	@foreach(App\Models\Payment::all() as $payment)
	<p>
      <input name="pay_id" type="radio" @if($payment->id == $order->pay_id) checked="true" @endif id="pay_id{{$payment->id}}" value="{{$payment->id}}" />
      <label for="pay_id{{$payment->id}}">{{$payment->pay_name}}</label>
    </p>
    @endforeach
    <input type="hidden" name="_method" value="PUT">
    <input type="hidden" name="id" value="{{$order->id}}">
	<button type="submit" class="btn red">
	 <i class="material-icons left">done</i>
		确认选择
	</button>
    {!!Form::close()!!}
    </div>
    </div>
    </div>

@stop