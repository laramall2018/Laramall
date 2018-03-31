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
        <li class="collection-header">
        <h5>
        	<a href="{!!$root->url()!!}">{!!$root->cat_name!!}</a>
        </h5>
        </li>
		@foreach($root->children()->get() as $category)
		<li class="collection-item">
			<div>
				<a href="{!!$category->url()!!}">{!!$category->cat_name!!}</a>
				@if(!$category->isLeaf())
				<a href="{!!url('catalog/'.$category->id)!!}" class="secondary-content">
				<i class="material-icons">keyboard_arrow_right</i>
				</a>
				@endif
		   </div>
		</li>
		@endforeach
		</ul>
       <!--category end -->
       <a href="{!!$back_url!!}" class="btn">返回上一页</a>
       </div>
       </div><!--/col s12-->
       </div><!--/row-->

@stop
