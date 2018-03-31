@extends('materialize.layout.common')
@section('title')
{!!$title!!}
@stop
@section('content')


       @include('materialize.lib.breadcrumb')
       
       <div class="row">
       <div class="col s12">
       <div class="card-panel">
       <!--显示商品分类-->
        <ul class="collection with-header"> 
        <li class="collection-header"><h5>所有分类</h5></li>
		@foreach(App\Models\Category::roots()->get() as $category)
		<li class="collection-item">
			<div>
				<a href="{!!$category->url()!!}">{!!$category->cat_name!!}</a>
				@if($category->children()->count() > 0)
				<a href="{!!url('catalog/'.$category->id)!!}" class="secondary-content">
				<i class="material-icons">keyboard_arrow_right</i>
				
				</a>
				@endif
		   </div>
		</li>
		@endforeach
		</ul>
       <!--category end -->
       </div>
       </div><!--/col s12-->
       </div><!--/row-->

@stop
