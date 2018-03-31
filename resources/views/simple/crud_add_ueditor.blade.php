@extends('simple.layout.common')
@section('title')
{!!$title!!}
@stop

@section('script')
{!!HTML::script('files/jquery.validate.min.js')!!}
{!!HTML::style('static/icheck/skins/all.css')!!}
{!!HTML::script('static/icheck/icheck.js')!!}
{!!HTML::script('files/bootstrap/js/bootstrap.min.js')!!}
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
<script type="text/javascript" src="{!!url('files/bootstrap-filestyle.min.js')!!}"></script>
    <div class="content-box">
    	
       {!!$path_url!!}
    	
       <div class="panel panel-success">
  					<div class="panel-heading">{!!$action_name!!}</div>
  					<div class="panel-body">
    					{!!$form!!}
  					</div>
				</div>
                
    </div>
 
 <script type="text/javascript">
	ps.icheckbox();
    ps.privi_checkbox();
	ps.create_upload_img_form();
	$(":file").filestyle({buttonText: "上传图片"});

</script>
@include('simple.lib.js_baidu')
@stop
