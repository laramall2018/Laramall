@extends('matrix.layout.common')
@section('title')
{!!$title!!}
@stop

@section('content')
<link href="{!!url('front/matrix/animate.css')!!}" rel="stylesheet" type="text/css" />

   
   <div class="container">
   		<p class="text-info">{!!trans('front.404')!!}</p>
   </div>
   
@stop