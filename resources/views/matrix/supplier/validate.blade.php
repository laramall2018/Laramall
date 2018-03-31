@extends('matrix.layout.common')
@section('title')
{!!$title!!}
@stop

@section('content')
<link href="{!!url('front/matrix/animate.css')!!}" rel="stylesheet" type="text/css" />

   @include('matrix.lib.breadcrumb')
   
   <div class="container">
   <div class="row">
   <div class="col-md-6 col-md-offset-3">
   <div class="panel panel-success">
   		<div class="panel-heading">
        	<h5>{!!trans('front.message')!!}</h5>
        </div>
        <div class="panel-body">
        
   		@if($messages)
        @foreach($messages->all() as $message)
        <div class="alert alert-danger">
        	<i class="fa fa-times"></i>
        	{!!$message!!}
        </div>
        @endforeach
        @endif
        
        <div class="alert alert-info">
        	<a href="{!!$back_url!!}" class="btn btn-success">{!!trans('front.back_url')!!}</a>
        </div>
        </div><!--/panel-body-->
        </div><!--/panel-->
   </div><!--/col-md-12-->
   </div><!--/row-->
   </div><!--/container-->
@stop