@extends('matrix.layout.common')
@section('title')
{!!$title!!}
@stop

@section('content')
<link href="{!!url('front/matrix/animate.css')!!}" rel="stylesheet" type="text/css" />

   @include('matrix.lib.breadcrumb')
   
   <div class="container">
   <div class="row">
   		<div class="col-md-3">
        	@include('matrix.supplier.center.menu')
        </div>
        <div class="col-md-9">
        	@include('matrix.supplier.center.content')
        </div>
   </div><!--/row-->
   </div><!--/container-->
@stop