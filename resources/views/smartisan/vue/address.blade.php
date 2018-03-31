<script type="text/javascript">
	var addressapp = new Vue({

		el:'#addressapp',
		data:{

				rows:[],
		},
		created:function(){

				this.getList();
		},
		methods:{

				//获取json数据
				getList:function(data){
						$.ajax({
							url:"{{url('api/user/address')}}",
							type:"GET",
							dataType:'json',
							success:function(data){
								addressapp.rows 	= data.data;
							}
						})
				},

				//编辑地址信息
				updateAddress:function(address){

					var  param				= {};
						 param.id 			= address.id;
						 param.province 	= $('#province'+address.id).val();
						 param.city 		= $('#city'+address.id).val();
						 param.district 	= $('#district'+address.id).val();
						 param.address 		= address.address;
						 param.consignee 	= address.consignee;
						 param.phone 		= address.phone;

						 //ajax更新地址信息
						 $.ajax({
						 	type:'PUT',
						 	url:"{{url('api/user/address/update')}}",
						 	data:'param='+$.toJSON(param),
						 	dataType:'json',
						 	success:function(data){
						 		var content 					= data.data;
						 		if(content.tag == 'error'){
						 			return false;
						 		}
						 		addressapp.rows.address_list	= content.address_list;
						 		$('#myModal'+address.id).modal('hide');
						 	}
						 })
				},

				//设置默认地址
				setDefault:function(address){

					$.ajax({
						url:"{{url('api/user/address/default')}}",
						type:"POST",
						data:'id='+address.id,
						dataType:'json',
						success:function(data){
							var content 				  = data.data;
							addressapp.rows.address_list  = content.address_list;
						}
					})
				},
				//三级联查获取省会城市地区信息
				pcd:function(event){
					var that 			= event.currentTarget;
					var  region_id 		= $(that).val();
					$.ajax({
						type:'POST',
						url:"{{url('api/user/address/pcd')}}",
						data:'region_id='+ region_id,
						dataType:'json',
						success:function(data){
							var content 						= data.data;
							var type 							= content.type;
							var tag 							= content.tag;
							if(tag == 'error'){
								return false;
							}
							if(type == 1){
								addressapp.rows.city_list 	   = content.city_list;
							}
							if(type == 2){
								addressapp.rows.district_list 	= content.district_list;
							}
						}
					})
				},
				//添加新地址
				addAddress:function(){
					var param 						= {};
						param.consignee 			= $('#consignee').val();
						param.phone 				= $('#phone').val();
						param.province 				= $('#province').val();
						param.city 					= $('#city').val();
						param.district 				= $('#district').val();
						param.address 				= $('#address').val();

						$.ajax({
							type:'POST',
							url:"{{url('api/user/address')}}",
							data:'param='+$.toJSON(param),
							dataType:"json",
							success:function(data){
								var content 		= data.data;
								if(content.tag == 'error'){
									swal(content.info);
						 			return false;
						 		}
						 		addressapp.rows.address_list	= content.address_list;
						 		$('#myModalNew').modal('hide');
							}
						})
				},
				//删除地址信息
				delAddress:function(id){
					$.ajax({
						type:'DELETE',
						url:"{{url('api/user/address/delete')}}",
						data:'id='+id,
						dataType:'json',
						success:function(data){
							var  content 					= data.data;
							if(content.tag == 'error'){
								swal(content.info);
								return false;
							}
							addressapp.rows.address_list	= content.address_list;
						}
					})
				}
		},
	})
</script>
