@extends('matrix.layout.common')
@section('title')
{!!$title!!}
@stop

@section('content')
<link href="{!!url('front/matrix/animate.css')!!}" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{!!url('front/matrix/js/category.ajax.js')!!}"></script>

   @include('matrix.lib.breadcrumb')

   <div class="container">
   <div class="list-box">
   <div class="row">
   @include('matrix.lib.category_tree')
   @include('matrix.lib.goods_list')
   @include('matrix.lib.popbox')
   </div><!--/row-->
   </div><!--/list-box-->
   </div><!--/container-->
   <script type="text/javascript">
   	 $(function(){
		cat.select("{!!url('category-ajax')!!}","{!!$cat->id!!}");
		cat.thumb();
	 });
   </script>
@stop
