@extends('simple.layout.common')
@section('title')
{!!$title!!}
@stop

@section('script')
{!!HTML::script('files/jquery.validate.min.js')!!}
{!!HTML::style('static/icheck/skins/all.css')!!}
{!!HTML::script('static/icheck/icheck.js')!!}
{!!HTML::script('files/bootstrap/js/bootstrap.min.js')!!}
{!!HTML::script('files/bootstrap/js/bootstrap.min.js')!!}
{!!HTML::script('static/js/jquery.json-2.4.js')!!}
<script type="text/javascript" src="{!!url('files/bootstrap-filestyle.min.js')!!}"></script>
<script type="text/javascript" src="{!!url('files/jquery-ui/jquery-ui-1.10.1.custom.js')!!}"></script>
<script src="{{url('front/vue/vue.min.js')}}" type="text/javascript"></script>
{!!HTML::style('files/jquery-ui/start/jquery-ui-1.10.1.custom.min.css')!!}
{!!$form_validate_url!!}
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
<script type="text/javascript">
$(function(){
	
	ps.goods_tab();
});
</script>

    <div class="content-box">
    	
       {!!$path_url!!}
    	
       <div class="panel panel-success panel-privi-box">
  					<div class="panel-heading">{!!$action_name!!}</div>
  					<div class="panel-body">
                    
                    	<div class="ps-tab">
                  
                   
                   {!!Form::open(['url'=>'admin/template','method'=>'post','files'=>true,'class'=>'form-horizontal'])!!}
                   
                    <ul class="ps-tab-title">
                    	
                      <li class="cur">模板选择</li>
                      <li>模板设置</li>
                     
                        
                    </ul>
                    
                    <div class="ps-tab-content">
                    		
                        @include('simple.template.lib.list')
                        @include('simple.template.lib.base')
                       
                    </div>          
               		{!!Form::close()!!}
               </div><!--/ps-tab-->
    					
  					</div>
				</div>
                
    </div>
 
 <script type="text/javascript">
	
 </script>
@stop
