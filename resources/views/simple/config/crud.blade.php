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
                  
                   
                   {!!Form::open(['url'=>'admin/config','method'=>'post','files'=>true,'class'=>'form-horizontal'])!!}
                   
                    <ul class="ps-tab-title">
                    	<li class="cur">网店信息</li>
                        <li>基本信息</li>
                        <li>其他设置</li>
                        <li>模板设置</li>
                        <li>微信接口</li>
                    </ul>
                    
                    <div class="ps-tab-content">
                    		
                        @include('simple.config.lib.shop')
                        @include('simple.config.lib.base')
                        @include('simple.config.lib.other')
                        @include('simple.config.lib.template')
                        @include('simple.config.lib.weixin')
                    </div>
                        
                        <div class="alert alert-success">
                        	所有信息都添加完毕后 再递交确认按钮
                        </div>
                    	<div class="form-group">
                        	<div class="col-md-offset-3 col-md-9">
                            	<input type="submit" name="submit" class="btn btn-primary" value="确认添加" />
                                
                            </div>
                        </div><!--/form-group-->              
               		{!!Form::close()!!}
               </div><!--/ps-tab-->
    					
  					</div>
				</div>
                
    </div>
 
 <script type="text/javascript">
	ps.icheckbox();
    ps.privi_checkbox();
	$(":file").filestyle({buttonText: "上传图片"});
	ps.timepicker();
</script>
@stop
