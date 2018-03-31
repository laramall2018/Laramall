@extends('matrix.layout.common')
@section('title')
{!!$title!!}
@stop

@section('content')
<link href="{!!url('front/matrix/animate.css')!!}" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{!!url('front/matrix/bootstrap/js/bootstrap.js')!!}"></script>
<script type="text/javascript" src="{!!url('front/matrix/js/category.ajax.js')!!}"></script>
   @include('matrix.lib.breadcrumb')

   <div class="container">
   <div class="list-box">
   <div class="row brand-list">

    @include('matrix.lib.brand_detail')
   </div><!--/row-->
   @include('matrix.lib.brand_goods_list')
   </div><!--/list-box-->
   </div><!--/container-->
@stop
