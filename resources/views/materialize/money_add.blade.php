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
		{!!Form::open(['url'=>'auth/mobile/money','method'=>'post','class'=>'col s12'])!!}
		
		 
  		 <div class="input-field col s12">
    		<select name="type">
      			<option value="" disabled selected>请选择</option>
      			<option value="0">充值</option>
      			<option value="1">提现</option>
      			
    		</select>
    		<label>请选择类型</label>
  		 </div>

  		 <div class="input-field col s12">
          <textarea id="user_note" name="user_note" class="materialize-textarea"></textarea>
          <label for="user_note">备注</label>
         </div>

         <div class="input-field col s12">
          <input id="amount" name="amount" type="text" class="validate">
          <label for="amount">金额</label>
         </div>

         <div class="input-field col s12">
          <input id="payment" name="payment" type="text" class="validate">
          <label for="payment">支付方式</label>
         </div>

         

		   <input type="hidden" name="username" value="{{$user->username}}">
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