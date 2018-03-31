@extends('simple.layout.common')
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

@section('script')
{!!HTML::style('static/icheck/skins/all.css')!!}
{!!HTML::script('static/icheck/icheck.js')!!}
{!!HTML::script('files/bootstrap/js/bootstrap.min.js')!!}
{!!HTML::script('files/jquery.confirm.js')!!}
{!!HTML::script('static/js/jquery.json-2.4.js')!!}
{!!HTML::script('static/js/phpstore.grid.js')!!}
@stop


@section('content')

<div class="content-box">

	<div class="row">
    	<div class="col-md-12">
        	{!!$path_url!!}
        </div>
    </div>

    <div class="row">
    <div class="col-md-12 offset-bottom">
        	{!!$add_btn!!}
    </div>
    </div><!--/widget-title-->
    
    <div class="panel panel-primary">
    
    <div class="panel-heading">
    	<div class="caption">
        	ajax搜索
        </div><!--/caption-->
    </div>
    
    <div class="panel-body">
    
    
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
<script type="text/javascript">
	ps.icheckbox();
    ps.privi_checkbox();
	ps.confirm();
	ps.batch();
</script>
<script type="text/javascript">
	$(function(){
		ps.ui.grid("{!!$ajax_url!!}","{!!csrf_token()!!}",'{!!$searchInfo!!}');
	});
</script>
@stop

