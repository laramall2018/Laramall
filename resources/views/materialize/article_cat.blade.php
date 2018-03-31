@extends('materialize.layout.common')
@section('title')
{!!$title!!}
@stop
@section('content')

	@include('materialize.lib.breadcrumb')
	<div class="row">
	<div class="col s12">
	<div class="card-panel">
	<ul class="collection">
	@if($cat->article()->count() > 0)
	@foreach($cat->article()->get() as $article)
    <li class="collection-item avatar">
      <i class="material-icons circle green">insert_chart</i>
      <a href="{!!$article->url()!!}">{!!$article->title!!}</a>
      <p>{!!$article->description!!}<br>
         {!!$article->time()!!}
      </p>
      
    </li>
	@endforeach

	@else
	<li class="collection-item">没有记录</li>
	@endif
	</ul>
	<a href="{!!url('help')!!}" class="btn">返回上一页</a>
	</div>
	</div><!--/col s12-->
	</div><!--row-->

@stop