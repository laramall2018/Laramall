@extends('materialize.layout.common')
@section('title')
{!!$title!!}
@stop

@section('content')

   @include('materialize.lib.breadcrumb')

     
     <div class="row">
     <div class="col s12">
     <div class="card-panel">
     <div class="card-title">{!!trans('front.message')!!}</div>
     <div class="card-content">
        	
            <p class="red-text">
                <i class="material-icons middle">clear</i>
                {!!$info!!}
            </p>

        	<a class="btn" href="{!!$back_url!!}">
        	 {!!$url_name!!}
        	</a>

     </div><!--/panel-body-->
     </div><!--/panel-->
     </div><!--/col-md-6-->
     </div><!--/row-->
    
     
@stop
