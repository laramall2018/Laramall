@extends('materialize.layout.common')
@section('title')
{!!$title!!}
@stop

@section('content')
       <div class="row">
       <div class="col s12">
       <div class="card-panel">
       		<div class="info">
       			页面未找到
       		</div>
       		<a href="{!!url('/')!!}" class="btn red">返回首页</a>
       </div>
       </div>
       </div>
@stop