@extends('api.layout.common')

@section('title')
{{$title}}
@stop

@section('content')
<div class="container">
		<div class="row">
			
			<div class="panel panel-info panel-common">
				<div class="panel-heading">
					api测试注册页面
				</div>
				<div class="panel-body">
					<form class="form-horizontal" role="form">
			
  							<div class="form-group">
    							<label for="username" class="col-sm-2 control-label">用户名称</label>
    							<div class="col-sm-10">
      							<input type="text" class="form-control" id="username" placeholder="用户名称">
    							</div>
  							</div>
  							<div class="form-group">
    							<label for="password" class="col-sm-2 control-label">用户密码</label>
    							<div class="col-sm-10">
      							<input type="password" class="form-control" id="password" placeholder="密码">
    							</div>
  							</div>
  				
  
  							<div class="form-group">
    							<div class="col-sm-offset-2 col-sm-10">
      							<span class="btn btn-success" id="login-btn">
								<i class="fa fa-checke"></i>
								确认登录
      							</span>
    							</div>
  							</div>
					</form>
				</div><!--/body-->
			</div><!--/panel-->
			
		</div><!--/row-->
	</div><!--/container-->

	<script type="text/javascript">
		$(function(){

			api.login("{{url('api/login')}}");
		})
	</script>
@stop