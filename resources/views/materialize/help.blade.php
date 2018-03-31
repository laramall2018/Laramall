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
	@foreach(App\Models\ArticleCat::all() as $cat)
    <li class="collection-item avatar">
      <i class="material-icons circle green">insert_chart</i>
      <a href="{!!$cat->url()!!}">{!!$cat->cat_name!!}</a>
      <p>新闻数量<br>
         {!!$cat->article()->count()!!}
      </p>
      <a href="{!!$cat->url()!!}" class="secondary-content"><i class="material-icons">grade</i></a>
    </li>
	@endforeach
	</ul>
	</div>
	</div><!--/col s12-->
	</div><!--row-->

@stop