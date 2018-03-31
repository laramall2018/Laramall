@extends('matrix.layout.common')
@section('title')
{!!$title!!}
@stop

@section('content')
<link href="{!!url('front/matrix/animate.css')!!}" rel="stylesheet" type="text/css" />

   @include('matrix.lib.breadcrumb')
   
   @include('matrix.supplier.login.form')
@stop