@extends('materialize.layout.common')
@section('title')
{!!$title!!}
@stop

@section('content')
       @include('materialize.lib.breadcrumb')
       @include('materialize.lib.address.detail')
       <script type="text/javascript">
  			$(document).ready(function(){
    			$('select').material_select();
    			front.address.delete("{!!url('mobile/address')!!}","{!!url('checkout')!!}","{!!csrf_token()!!}");

    			front.address.pcd("{!!url('pcd')!!}","{!!csrf_token()!!}");
  			});  
		</script>
@stop