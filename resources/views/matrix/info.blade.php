@extends('matrix.layout.common')
@section('title')
{!!$title!!}
@stop

@section('content')

   @include('matrix.lib.breadcrumb')
   
   @if($article_info)
   <div class="container">
   		
        <div class="alert alert-info">
        	{!!$info!!}
        </div><!--/alert-->
        <div class="alert alert-info">
        	<a class="btn btn-success" href="{!!$back_url!!}">{!!trans('front.back_url')!!}</a>
        </div>
   </div>
   @endif
@stop