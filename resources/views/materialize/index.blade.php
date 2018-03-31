@extends('materialize.layout.common')
@section('title')
{!!$title!!}
@stop

@section('content')
       @include('materialize.lib.slider')
       @include('materialize.lib.goods_tab')

       <script type="text/javascript">
       	$(function(){

       		front.goods.collect("{!!url('mobile-collect')!!}","{!!csrf_token()!!}");
       	})
       </script>
@stop
