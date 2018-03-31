@extends('matrix.layout.common')
@section('title')
{!!$title!!}
@stop

@section('content')
<link href="{!!url('front/matrix/animate.css')!!}" rel="stylesheet" type="text/css" />

  <div class="main-box">

    <div class="main-box-bb">

        <div class="row">
           @include('matrix.lib.category_home')
           @include('matrix.lib.slider')
        </div><!--/row-->

    </div><!--/bb-->
  </div><!--/main-box-->

  @include('matrix.lib.ad')
  @include('matrix.lib.new_goods')
  @include('matrix.lib.hot_goods')
  @include('matrix.lib.best_goods')
  @include('matrix.lib.popbox')

@stop
