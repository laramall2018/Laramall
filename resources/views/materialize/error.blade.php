@extends('materialize.layout.common')
@section('title')
{!!$title!!}
@stop

@section('content')

   @include('materialize.lib.breadcrumb')

     
     
        	<div class="row">
            <div class="col s12">
            <div class="card-panel">
            @foreach($messages->all() as $message)
            <p><strong class="red-text">{!!$message!!}</strong></p>
            @endforeach
            </div>
            </div>
            </div>
            <div class="row">
            <div class="col s12">
            <a class="btn" href="{!!$back_url!!}">返回</a>
            </div>
            </div>
@stop
