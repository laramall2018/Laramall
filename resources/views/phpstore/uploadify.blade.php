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
    
    <div class="content">
    	
        <div class="tab-content">
							<div class="tab-pane active" id="tab_0">
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
										<!-- BEGIN FORM-->
                                        <div id="goods-img-list"></div>
       									<div class="img-upload">
											<div id="queue"></div>
											<input id="file_upload" name="file_upload" type="file" multiple="true"> 
      									</div>
										<!-- END FORM-->
									</div>
								</div>
								
							</div>
							
	   </div>
        
    
    </div>
@stop