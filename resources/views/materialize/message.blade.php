@extends('materialize.layout.common')
@section('title')
{!!$title!!}
@stop

@section('content')
@include('materialize.lib.breadcrumb')
<div class="row">
<div class="col s12">
<a href="{{$back_url}}" class="btn offset-top10">返回</a>
<a href="{{url('auth/mobile/message/create')}}" class="btn red offset-top10">添加</a>
<div class="card-panel">
		
		<ul class="collection">
		@foreach($user->message()->paginate(20) as $message)
   
		<li class="collection-item avatar">
		
        @if($message->goods)
          @if($message->goods->gallery()->first()->thumb)
          <img src="{!!url($message->goods->gallery()->first()->thumb)!!}" class="circle">
          @endif
        @else
      	<i class="material-icons circle green">insert_chart</i>
        @endif
        
       <span class="title">
          <a href="{{url('auth/mobile/message/'.$message->id)}}">
          {{str_limit($message->content,20,'..')}}
          </a>
       </span>
      <p>
        {{$message->type}}<br>
        {{$message->status()}}<br>
      </p>

      <span  data-url="{{url('auth/mobile/message/delete/'.$message->id)}}"  class="btn-floating waves-effect waves-light grey secondary-content mobile-cancel-btn">
          <i class="material-icons left">clear</i>
      </span>
      
    </li>
   
		@endforeach
		</ul>

    {!!$user->message()->paginate(20)->render()!!}
</div>
</div>
</div>

<script type="text/javascript">
        $(function(){

            front.mobile.dom_cancel();
        })
</script>

@stop