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
		
		<ul class="collection">
		@foreach($user->collect()->paginate(20) as $collect)
		<li class="collection-item avatar">
		<a href="{{$collect->goods->url()}}">
        @if($collect->goods->gallery()->first())
        <img src="{!!url($collect->goods->gallery()->first()->thumb())!!}" class="circle">
        @else
      	<i class="material-icons circle green">insert_chart</i>
        @endif
        </a>
       <span class="title">
      	
      	<a href="{{$collect->goods->url()}}">{{$collect->goods->goods_name}}</a>
        </span>
      <p>
         收藏时间:{!!$collect->time()!!}<br>

      </p>
      
      <span  data-url="{{url('auth/mobile/collect/delete/'.$collect->id)}}"  class="btn-floating waves-effect waves-light secondary-content mobile-cancel-btn">
          <i class="material-icons left">clear</i>
      </span>
    </li>
		@endforeach
		</ul>

    {!!$user->collect()->paginate(20)->render()!!}
</div>
</div>
</div>

<script type="text/javascript">
        $(function(){

            front.mobile.dom_cancel();
        })
</script>

@stop
