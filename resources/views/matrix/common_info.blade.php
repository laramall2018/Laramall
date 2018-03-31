@extends('matrix.layout.common')
@section('title')
{!!$title!!}
@stop

@section('content')

   @include('matrix.lib.breadcrumb')

     <div class="container">
     <div class="row">
     <div class="col-md-6 col-md-offset-3">
     <div class="panel panel-info">
     <div class="panel-heading">{!!trans('front.message')!!}</div>
     <div class="panel-body">
        	{!!$info!!}
        	<div class="alert alert-info">
        		<span id="totalSecond" class="red">3</span>秒自动跳转
        	</div>

        	<a class="btn btn-success" href="{!!$back_url!!}">
        	 <span class="glyphicon glyphicon-arrow-left"></span>
        	 {!!trans('front.redirect_url')!!}
        	 </a>

     </div><!--/panel-body-->
     </div><!--/panel-->
     </div><!--/col-md-6-->
     </div><!--/row-->
     </div><!--/container-->
     <script type="text/javascript">
     $(function(){

     	var second = $('#totalSecond').html();
     		second = parseInt(second);

     		function mytime(){
     			 $('#totalSecond').html(second);
     			 second = second -1 ;

     			if(second < 0){
     				 window.location.href="{!!$back_url!!}";
     			}
            }

     		setInterval(mytime, 1000);
     });

     </script>

@stop
