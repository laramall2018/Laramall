@extends('matrix.layout.common')
@section('title')
{!!$title!!}
@stop

@section('content')
<link href="{!!url('front/matrix/animate.css')!!}" rel="stylesheet" type="text/css" />
@include('matrix.lib.breadcrumb')
   
   <div class="container">
   <div class="row">
   <div class="col-md-6 col-md-offset-3">
   <div class="panel panel-success">	
   <div class="panel-heading">
   	<h5>{!!trans('front.message')!!}</h5>
   </div><!--/panel-heading-->
   <div class="panel-body">
  		
        <div class="alert alert-success">
        	
            {!!$info!!}
        </div>
        <div class="alert alert-info">
    		<a href="{!!$back_url!!}" class="btn btn-success">
                <i class="fa fa-chevron-circle-left"></i>
            	{!!trans('front.supplier_center')!!}
            </a>
        </div>
   </div><!--/panel-body--> 
   </div><!--/panel-->
   </div><!--/col-md-6-->
   </div><!--/row--> 
   </div><!--/container-->
	   
@stop
