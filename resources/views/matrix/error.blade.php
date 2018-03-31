@extends('matrix.layout.common')
@section('title')
{!!$title!!}
@stop

@section('content')
<link href="{!!url('front/matrix/animate.css')!!}" rel="stylesheet" type="text/css" />
@include('matrix.lib.breadcrumb')
   
   <div class="container">
   		<div class="bg-info validate-info">
        @if($messages)
        @foreach($messages->all() as $item)
        <p>{!!$item!!}</p>
        @endforeach
        @endif
        </div>
   </div>
   <div class="container text-center" style="margin-top:10px;">
   		<a class="btn btn-danger" href="{!!$back_url!!}">
        	<i class="fa fa-chevron-circle-left"></i>
            &nbsp;&nbsp;&nbsp;
        	返回
       </a>
   </div>
	   
@stop