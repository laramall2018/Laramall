@extends('materialize.layout.common')
@section('title')
{!!$title!!}
@stop
@section('content')
<script type="text/javascript" src="{!!url('front/materialize/js/jquery.json-2.4.js')!!}"></script>
<script type="text/javascript" src="{!!url('front/materialize/js/category.ajax.js')!!}"></script>


       @include('materialize.lib.breadcrumb')
       @include('materialize.lib.select')
       @include('materialize.lib.goods_list')
       <script type="text/javascript">
       	$(function(){

       		front.goods.collect("{!!url('mobile-collect')!!}","{!!csrf_token()!!}");
       	})
       </script>

@stop
