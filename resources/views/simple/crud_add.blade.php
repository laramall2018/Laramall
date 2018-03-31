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
{!!$crud_js!!}
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
</script>

@if($tag == 'admin.role.index')
<script type="text/javascript">
	ps.panel();
</script>
@endif

@if($tag == 'admin.product.index')
  <script type="text/javascript">
   $(function(){

     product.select("{!!url('admin/product/ajax')!!}");

   })
  </script>
@endif


@stop
