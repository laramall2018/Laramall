@extends('matrix.layout.common')
@section('title')
{!!$title!!}
@stop

@section('content')
<link href="{!!url('front/matrix/animate.css')!!}" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{!!url('front/matrix/bootstrap/js/bootstrap.js')!!}"></script>
   @include('matrix.lib.breadcrumb')
   
   <div class="container">
   <div class="list-box">
   <div class="row">
   	@include('matrix.lib.user.menu')
    @include('matrix.lib.user.return_form')
   </div><!--/row--> 
   </div><!--/list-box-->
   </div><!--/container-->
@stop