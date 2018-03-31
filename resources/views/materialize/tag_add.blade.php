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
		{!!Form::open(['url'=>'auth/mobile/tag','method'=>'post','class'=>'col s12'])!!}
		
		 <div class="input-field col s12">
    		<select name="goods_id">
      			<option value="" disabled selected>请选择</option>
      			@foreach(App\Models\Goods::all() as $goods)
				    <option value="{{$goods->id}}"> {{$goods->goods_name}}</option>
      			@endforeach
    		</select>
    		<label>请选择订单</label>
  		 </div>
  		 
  		 <input type="hidden" name="username" value="{{$user->username}}">

       

         <div class="input-field col s12">
          <input id="tag_name" name="tag_name" type="text" class="validate">
          <label for="tag_name">标签名称</label>
         </div>

         <div class="input-field col s12">
          <input id="sort_order" name="sort_order" type="text" value="0" class="validate">
          <label for="sort_order">排序</label>
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