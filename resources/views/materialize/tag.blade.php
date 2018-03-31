@extends('materialize.layout.common')
@section('title')
{!!$title!!}
@stop

@section('content')
@include('materialize.lib.breadcrumb')
<div class="row">
<div class="col s12">
<a href="{{$back_url}}" class="btn offset-top10">返回</a>
<a href="{{url('auth/mobile/tag/create')}}" class="btn red offset-top10">添加</a>
<div class="card-panel">
		
		<ul class="collection">
		@foreach($user->tag()->paginate(20) as $tag)
    @if($tag->goods)
		<li class="collection-item avatar">
		<a href="{{$tag->goods->url()}}">
        @if($tag->goods->gallery()->first())
        <img src="{!!url($tag->goods->gallery()->first()->thumb)!!}" class="circle">
        @else
      	<i class="material-icons circle green">insert_chart</i>
        @endif
        </a>
       <span class="title">
      	<a href="{{$tag->goods->url()}}">{{$tag->tag_name}}</a>
       </span>
      <p>
        {!!$tag->time()!!}<br>
      </p>

      <span  data-url="{{url('auth/mobile/tag/delete/'.$tag->id)}}"  class="btn-floating waves-effect waves-light red secondary-content mobile-cancel-btn">
          <i class="material-icons left">clear</i>
      </span>
      
    </li>
    @endif
		@endforeach
		</ul>

    {!!$user->tag()->paginate(20)->render()!!}
</div>
</div>
</div>

<script type="text/javascript">
        $(function(){

            front.mobile.dom_cancel();
        })
</script>

@stop