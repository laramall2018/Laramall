@extends('smartisan.layout.user')

@section('title')
{{$title}}
@stop

@section('content')
	@include('smartisan.user.register')
@stop