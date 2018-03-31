@extends('materialize.layout.common')
@section('title')
{!!$title!!}
@stop

@section('content')
       @include('materialize.lib.breadcrumb')
       @include('materialize.lib.article.detail')
      
@stop