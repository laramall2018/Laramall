@extends('simple.layout.login')

@section('title')
{{$title}}
@stop

@section('content')
	
	@include('simple.login.form')
	@include('simple.login.vue.login')
@stop