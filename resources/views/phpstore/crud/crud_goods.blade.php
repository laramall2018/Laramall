@extends('phpstore.layout.common-uploadify')
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
	
    
    <div class="row">
    <div class="col-md-12">
       
        <div class="portlet box green">
			<div class="portlet-title">
										<div class="caption">
											<i class="fa fa-reorder"></i>
                                            {!!$action_name!!}
										</div>
										<div class="tools">
											<a href="javascript:;" class="collapse">
											</a>
											<a href="#portlet-config" data-toggle="modal" class="config">
											</a>
											<a href="javascript:;" class="reload">
											</a>
											<a href="javascript:;" class="remove">
											</a>
										</div>
									</div>
			
            <div class="portlet-body">
			    
                                   
               <div class="ps-tab">
                {!!Form::open(['url'=>$crud->get('url'),'method'=>'post','files'=>true,'class'=>'form-horizontal'])!!}   
                    {!!$tab!!}
                    
                                      
                   <div class="ps-tab-content">
                   <div class="form-body">
                     {!!$tab_content!!}                  	
                   
                    
                     {!!$submit!!}
                   </div><!--/form-body-->
                    </div><!--/ps-tab-content-->
                    
                {!!Form::close()!!}    
               </div><!--/ps-tab-->
                            
			</div><!--/portlet-body-->
                                    
		</div><!--/portlet-->
													
    </div>
    </div>
@stop