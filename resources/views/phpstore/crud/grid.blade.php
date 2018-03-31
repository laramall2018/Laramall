@extends('phpstore.layout.common-grid')
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

    <div class="alert alert-success">
        	{!!$add_btn!!}
    </div><!--/widget-title-->
    
    <div class="portlet box purple">
    
    <div class="portlet-title">
    	<div class="caption">
        	ajax搜索
        </div><!--/caption-->
        <div class="tools">
        	<a href="javascript:;" class="collapse"></a>
            <a href="javascript:;" class="reload"></a>
        </div><!--/tools-->
    </div>
    
    <div class="portlet-body">
    
    
    {!!$search!!}
    
    </div>
    </div>
    
    
    
    
    
    {!!Form::open(array('url'=>$batch_url,'method'=>'post','class'=>'common-form'))!!}
    	
	 <div id="ajax-box">
        
    	{!!$grid->portlet()!!}
        
      </div>
	
	{!!Form::hidden('del_type','softdel',array('id'=>'del_type'))!!}
	
    
    
    {!!$batch_btn!!}
    
    {!!Form::close()!!}
    
    
    <div id="ajax-page-bar">
        <div id="ajax-page">
         {!!$grid->links()!!}
        </div>
        <div class="ajax-total">
        总记录为：{!!$grid->total()!!}
        </div>
        </div>
     
    </div><!--/content-->
    
</div><!--/widget-->

@stop

