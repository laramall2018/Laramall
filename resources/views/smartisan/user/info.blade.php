<div id="userroot">
<table class="table table-striped table-hover table-bordered order-tab">
				<tr>
						<th style="width:150px;">{!!trans('front.username')!!}</th>
						<td v-text="rows.username">
							@{{rows.username}}
						</td>
				</tr>
				<tr>
						<th>{!!trans('front.rank_name')!!}</th>
						<td>@if($rank) {!!$rank->rank_name!!} @endif</td>
				</tr>
				<tr>
					 <th>{!!trans('front.email')!!}</th>
					 <td>@{{rows.email}}</td>
				</tr>
				<tr>
					 <th>{!!trans('front.phone')!!}</th>
					 <td>@{{rows.phone}}</td>
				</tr>
				<tr>
					 <th>{!!trans('front.nickname')!!}</th>
					 <td>@{{rows.nickname}}</td>
				</tr>
				<tr>
					 <th>{!!trans('front.sex')!!}</th>
					 <td>@{{rows.sexName}}</td>
				</tr>
				<tr>
					 <th>{!!trans('front.birthday')!!}</th>
					 <td>@{{rows.birthday}}</td>
				</tr>
				<tr>
					 <th>{!!trans('front.sfz')!!}</th>
					 <td>@{{rows.sfz}}</td>
				</tr>
				<tr>
					 <th>{!!trans('front.pay_points')!!}</th>
					 <td>@{{rows.pay_points}}</td>
				</tr>
				<tr>
					 <th>{!!trans('front.rank_points')!!}</th>
					 <td>@{{rows.rank_points}}</td>
				</tr>
				<tr>
					 <th>{!!trans('front.register_ip')!!}</th>
					 <td>@{{rows.ip}}</td>
				</tr>
				<tr>
					 <th>{!!trans('front.login_ip')!!}</th>
					 <td>{!!Request::getClientIp()!!}</td>
				</tr>
				<tr>
					 <th>{!!trans('front.register_time')!!}</th>
					 <td>@{{rows.registerTimeFormat}}</td>
				</tr>
				<tr>
					 <th>{!!trans('front.last_login_time')!!}</th>
					 <td>@{{rows.lastLoginTimeFormat}}</td>
				</tr>
</table>

<button type="button" class="ls-btn-info" 
		data-toggle="modal" 
		data-target="#myModalEdit">
		<i class="fa fa-edit"></i>
		编辑用户资料
</button>
@include('smartisan.user.edit_user')
</div><!--/userroot-->
<script type="text/javascript">
	var userroot 	= new Vue({
		el:'#userroot',
		data:{
				password:'',
				rows:[],
		},
		created:function(){
			this.getList();
		},
		methods:{

			//获取列表
			getList:function(){
				$.ajax({
					url:"{{url('api/user')}}",
					type:"GET",
					dataType:'json',
					success:function(data){
						var content 	= data.data;
						if(content.tag == 'success'){
							userroot.rows = content.user;
						}
					}
				});
			},

			//更新用户资料
			updateForm:function(){
				var param = this.getParam();
				$.ajax({
					url:"{{url('api/user')}}",
					type:"PUT",
					data:'param='+ param,
					dataType:"json",
					success:function(data){

						var  content  = data.data;
						if(content.tag == 'error'){
							swal({
                                title: "表单数据异常",
                                text: content.info,
                                html: true
                        	});
                        	return false;
						}

						if(content.tag == 'success'){
							$('#myModalEdit').modal('hide')
						}
					}
				})
			},

			//获取ajax的参数
			getParam:function(){

				var  param 						= {};
					 param.username 			= this.rows.username;
					 param.email 				= this.rows.email;
					 param.phone 				= this.rows.phone;
					 param.nickname				= this.rows.nickname;
					 param.sex 					= this.rows.sex;
					 param.birthday 			= this.rows.birthday;
					 param.sfz 					= this.rows.sfz;
					 param.password 			= this.password;
					 return $.toJSON(param);
			},

		}

	});
</script>

