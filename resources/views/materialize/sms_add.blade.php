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
		{!!Form::open(['url'=>'auth/mobile/sms','method'=>'post','class'=>'col s12'])!!}
		    
        <div class="input-field col s12">
          <textarea id="textarea1" name="sms_content" class="materialize-textarea"></textarea>
          <label for="textarea1">消息内容</label>
        </div>
		 
       <input type="hidden" name="user_id" value="{{$user->id}}">

  		 <div class="input-field col s12">
  		 	<button type="submit" class="btn offset-top10">递交</button>
  		 	<a href=" {{$back_url}} " class="btn red offset-top10">返回</a>
  		 </div>

		{!!Form::close()!!}
		</div>

	</div>
	</div>
	</div>

	
@stop