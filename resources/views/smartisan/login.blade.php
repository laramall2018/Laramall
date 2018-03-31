@extends('smartisan.layout.user')

@section('title')
{{$title}}
@stop

@section('content')
	@include('smartisan.user.login')
@stop