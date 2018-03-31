@extends('materialize.layout.common')
@section('title')
{!!$title!!}
@stop

@section('content')
	@include('materialize.lib.breadcrumb')
	
	<div class="row">
	<div class="col s12">
	<div class="card-panel">
		
		<div class="row"> 
		{!!Form::open(['url'=>'auth/mobile/return','method'=>'post','class'=>'col s12'])!!}
		
		 <div class="input-field col s12">
    		<select name="order_id">
      			<option value="" disabled selected>请选择</option>
      			@foreach($user->order()->where('pay_status',1)->where('return_status',0)->where('cancel_status',0)->get() as $order)
				<option value=" {{$order->id}} ">{{$order->order_sn}}</option>
      			@endforeach
    		</select>
    		<label>请选择订单</label>
  		 </div>
  		 <div class="input-field col s12">
  		 	<input type="text" id="username" name="username" value=" {{$user->username}} ">
  		 	<label for="username">退货姓名</label>
  		 </div>
  		 <input type="hidden" name="user_id" value="{{$user->id}}">
       <input type="hidden" name="reg_from" value="移动版本">
  		 <div class="input-field col s12">
    		<select name="type">
      			<option value="" disabled selected>请选择</option>
      			<option value="全部退货">全部退货</option>
      			<option value="部分退货">部分退货</option>
      			<option value="换货">换货</option>
    		</select>
    		<label>请选择退货类型</label>
  		 </div>

  		 <div class="input-field col s12">
          <textarea id="return_note" name="return_note" class="materialize-textarea"></textarea>
          <label for="return_note">退货说明</label>
         </div>

         <div class="input-field col s12">
          <input id="bank_name" name="bank_name" type="text" class="validate">
          <label for="bank_name">银行名称</label>
         </div>

         <div class="input-field col s12">
          <input id="bank_account" name="bank_account" type="text" class="validate">
          <label for="bank_account">银行账号</label>
         </div>

         <div class="input-field col s12">
          <input id="return_amount" name="return_amount" type="text" class="validate">
          <label for="return_amount">退货金额</label>
         </div>

		
  		 <div class="input-field col s12">
  		 	<button type="submit" class="btn offset-top10">递交</button>
  		 	<a href=" {{$back_url}} " class="btn red offset-top10">返回</a>
  		 </div>

		{!!Form::close()!!}
		</div>

	</div>
	</div>
	</div>

	<script type="text/javascript">
		$(document).ready(function() {
    		$('select').material_select();
  		});
	</script>

@stop