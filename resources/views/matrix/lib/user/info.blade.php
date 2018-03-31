<div class="col-md-9">
<div class="panel panel-default">
<div class="panel-body">
<p class="tit">用户基本信息</p>

	<div class="user-info-box">

				@if(Auth::user('user')->icon())
				<img src="{{Auth::user('user')->icon()}}" class="img-thumbnail user-center-icon" style="width:100px;">
				@endif

				@if(Auth::user('user')->rank)
				@if(Auth::user('user')->rank->icon())
				<img src="{{Auth::user('user')->rank->icon()}}" />
				@endif
				@endif

		<table class="table table-striped table-hover table-bordered order-tab">
				<tr>
						<th style="width:150px;">{!!trans('front.username')!!}</th>
						<td>{!!Auth::user('user')->username!!}</td>
				</tr>
				<tr>
						<th>{!!trans('front.rank_name')!!}</th>
						<td>@if($rank) {!!$rank->rank_name!!} @endif</td>
				</tr>
				<tr>
					 <th>{!!trans('front.email')!!}</th>
					 <td>{!!Auth::user('user')->email!!}</td>
				</tr>
				<tr>
					 <th>{!!trans('front.phone')!!}</th>
					 <td>{!!Auth::user('user')->phone!!}</td>
				</tr>
				<tr>
					 <th>{!!trans('front.nickname')!!}</th>
					 <td>{!!Auth::user('user')->nickname!!}</td>
				</tr>
				<tr>
					 <th>{!!trans('front.sex')!!}</th>
					 <td>{!!$sex_name!!}</td>
				</tr>
				<tr>
					 <th>{!!trans('front.birthday')!!}</th>
					 <td>{!!Auth::user('user')->birthday!!}</td>
				</tr>
				<tr>
					 <th>{!!trans('front.sfz')!!}</th>
					 <td>{!!Auth::user('user')->sfz!!}</td>
				</tr>
				<tr>
					 <th>{!!trans('front.pay_points')!!}</th>
					 <td>{!!Auth::user('user')->pay_points!!}</td>
				</tr>
				<tr>
					 <th>{!!trans('front.rank_points')!!}</th>
					 <td>{!!Auth::user('user')->rank_points!!}</td>
				</tr>
				<tr>
					 <th>{!!trans('front.register_ip')!!}</th>
					 <td>{!!Auth::user('user')->ip!!}</td>
				</tr>
				<tr>
					 <th>{!!trans('front.login_ip')!!}</th>
					 <td>{!!Request::getClientIp()!!}</td>
				</tr>
				<tr>
					 <th>{!!trans('front.register_time')!!}</th>
					 <td><?php echo date('Y/m/d',Auth::user('user')->add_time);?></td>
				</tr>
				<tr>
					 <th>{!!trans('front.last_login_time')!!}</th>
					 <td>{!!$last_login_time!!}</td>
				</tr>


		</table>

		<span class="edit-user-profile btn btn-success">
			<span class="glyphicon glyphicon-pencil"></span>
			{!!trans('front.edit_profile')!!}
		</span>

		<div class="user-profile-div alert alert-info" style="display:none;">
		{!!Form::open(['url'=>'auth/user-update','method'=>'post','class'=>'form-horizontal','files'=>'true'])!!}

            <div class="form-group">
                <label class="col-sm-2 control-label">{!!trans('front.username')!!}</label>
                <div class="col-sm-5">
                	<input type="text" name="username" class="form-control" id="username" value="{!!Auth::user()->username!!}" disabled />
                </div>
            </div><!--/form-group-->
            <div class="form-group">
            	<label class="col-sm-2 control-label">{!!trans('front.user_icon')!!}</label>
                <div class="col-sm-5">
                	<input type="file" name="user_icon" />
                </div>
            </div>
            @if(Auth::user('user')->icon())
            <div class="form-group">

                <div class="col-sm-5 col-sm-offset-2">
                	<img src="{!!url(Auth::user('user')->icon())!!}" class="img-thumbnail" />
                </div>
            </div>
            @endif

            <div class="form-group">
                <label class="col-sm-2 control-label">{!!trans('front.email')!!}</label>
                <div class="col-sm-5">
                	<input type="text" name="email" class="form-control" id="email" value="{!!Auth::user()->email!!}"  />
                </div>
            </div><!--/form-group-->

            <div class="form-group">
                <label class="col-sm-2 control-label">{!!trans('front.phone')!!}</label>
                <div class="col-sm-5">
                	<input type="text" name="phone" class="form-control" id="phone" value="{!!Auth::user()->phone!!}" />
                </div>
            </div><!--/form-group-->
						<div class="form-group">
                <label class="col-sm-2 control-label">{!!trans('front.nickname')!!}</label>
                <div class="col-sm-5">
                	<input type="text" name="nickname" class="form-control" id="nickname" value="{!!Auth::user()->nickname!!}" />
                </div>
            </div><!--/form-group-->
						<div class="form-group">
                <label class="col-sm-2 control-label">{!!trans('front.sex')!!}</label>
                <div class="col-sm-5">
                	<select name="sex" class="form-control">
											<option value="0" @if(Auth::user('user')->sex == 0) selected="selected" @endif >男</option>
											<option value="1" @if(Auth::user('user')->sex == 1) selected="selected" @endif >女</option>
											<option value="2" @if(Auth::user('user')->sex == 2) selected="selected" @endif>保密</option>
									</select>
                </div>
            </div><!--/form-group-->
						<div class="form-group">
                <label class="col-sm-2 control-label">{!!trans('front.birthday')!!}</label>
                <div class="col-sm-5">
                	<input type="text" name="birthday" class="form-control" id="birthday" value="{!!Auth::user('user')->birthday!!}" />
                </div>
            </div><!--/form-group-->
						<div class="form-group">
                <label class="col-sm-2 control-label">{!!trans('front.sfz')!!}</label>
                <div class="col-sm-5">
                	<input type="text" name="sfz" class="form-control" id="birthday" value="{!!Auth::user('user')->sfz!!}" />
                </div>
            </div><!--/form-group-->

            <div class="form-group">
                <label class="col-sm-2 control-label">{!!trans('front.new_password')!!}</label>
                <div class="col-sm-5">
                	<input type="password" name="new_password" class="form-control" id="new_password" />
                </div>
            </div><!--/form-group-->
            <div class="form-group">
            	<div class="col-sm-10 col-sm-offset-2">
                	<input type="submit" class="btn btn-success" value="确认修改" />
                </div>
            </div>

    {!!Form::close()!!}
	  </div><!--/user-profile-div-->

	</div><!--/user-info-box-->

</div><!--/panel-body-->
</div><!--/panel-->
</div><!--/col-md-9-->
<script type="text/javascript">
		$(function(){

				front.user.edit();
		});
</script>
