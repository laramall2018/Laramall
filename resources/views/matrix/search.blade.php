@extends('matrix.layout.common')
@section('title')
{!!$title!!}
@stop

@section('content')
<link href="{!!url('front/matrix/animate.css')!!}" rel="stylesheet" type="text/css" />

   @include('matrix.lib.breadcrumb')
   
   <div class="container">
   <div class="list-box">
   <div class="row">
   @include('matrix.lib.search_goods_list')
   </div><!--/row--> 
   </div><!--/list-box-->
   </div><!--/container-->
@stop