@extends('phpstore.layout.common')
@section('title')
{!!$title!!}
@stop

@section('description')
{!!$description!!}
@stop

@section('keywords')
{!!$keywords!!}
@stop

@section('appname')
{!!$appname!!}
@stop


@section('content')

    <div class="content">
    	
        <div class="row">
        <div class="col-md-12">
        	
            {!!$portlet!!}
            
        </div><!--/col-md-12-->
        <div class="col-md-12">{!!$portlet2!!}</div>
        </div><!--/row-->
    </div><!--/content-->
@stop