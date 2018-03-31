<script type="text/javascript">
	var msgroot = new Vue({
		el:'#msgroot',
		data:{
			rows:[],
			option: [
						{ 'name':'留言','value':'留言'},
						{ 'name':'意见','value':'意见'},
						{ 'name':'建议','value':'建议'},
						{ 'name':'评价','value':'评价'},
			],
		},
		created:function(){
			this.getList();
		},
		methods:{

			//获取列表
			getList:function(){
				$.ajax({
					url:"{{url('api/message')}}",
					type:'GET',
					dataType:'json',
					success:function(data){
						var  content  = data.data;
						if(content.tag == 'success'){
							msgroot.rows 	= content;
						}
					}
				})
			},
			//show message detail
			showMsg:function(message){

				var  htmlContent 	= this.getContent(message);
				this.showTingleBox(htmlContent);
			},

			//show Tingle pop box
			showTingleBox:function(htmlContent){

				var  _this  = this;
				// instanciate new modal
				var modal = new tingle.modal({
    				footer: true,
    				stickyFooter: false,
    				cssClass: ['custom-class-1', 'custom-class-2']
    		    });

    		    modal.setContent(htmlContent);

					// add a button
					modal.addFooterBtn('关闭', 'tingle-btn tingle-btn--danger tingle-btn--pull-right', function() {
    					// here goes some logic
    					modal.close();
					});
					// open modal
					modal.open();
			},

			//put message into Html Dom string
			getContent:function(message){

				    var  _this  = this;
					// set content
					var  str = '<table class="table table-bordered table-striped table-hover order-tab">'
							 + _this.makeTr('类型',message.type)
							 + _this.makeTr('用户名称',message.username)
							 + _this.makeTr('留言时间',message.createTime)
							 + _this.makeTr('内容',message.content)
							 + _this.makeTr('电子邮件',message.email)
							 + _this.makeTr('等级',message.rankStar)
							 + _this.makeTr('留言IP',message.front_ip)
							 + _this.makeTr('状态',message.statusFormat)
							 + _this.makeTr('管理员',message.admin)
							 + _this.makeTr('回复',message.reply)
							 + _this.makeTr('回复时间',message.replyTimeFormat)
							 + _this.makeTr('回复IP',message.admin_ip)
							 + _this.makeTr('评价商品',message.goodsInfo)
							 + '</table>';
					return str;	
			},
			//make table's tr content  th and td
			makeTr:function(name,value){

				return '<tr><th style="width:100px;">'+ name +'</th><td>'+ value + '</td></tr>';
			},
			//delete message
			delMsg:function(id){
				 swal({
  						title: "确认删除？",
  						text: "确认从数据库中删除该条记录？",
  						type: "warning",
  						showCancelButton: true,
  						confirmButtonColor: "#DD6B55",
  						confirmButtonText: "确认",
  						cancelButtonText:"取消",
  						closeOnConfirm: false
					},
					function(){
						$.ajax({
							url:"{{url('api/message/delete')}}",
							type:"DELETE",
							data:'id='+id,
							dataType:'json',
							success:function(data){
								var  content 	= data.data;
								if(content.tag =='error'){
									swal(content.info);
									return false;
								}

								if(content.tag == 'success'){
									msgroot.rows = content;
									swal("删除成功", "您已经成功在数据库中删除该条记录", "success");
								}

							}
						});
					});
			},
			//add message
			addMsg:function(){
				var _this 		  = this;
				var option 		  = lsForm.option(_this.option);
				var rankOption    = lsForm.rankOption();
				var htmlContent   = lsForm.textarea('留言内容','content')
								  + lsForm.select('留言类型','type',option)
								  + lsForm.select('评价等级','rank',rankOption)
								  + lsForm.text('电子邮件','email');
				this.showNewTingleBox(lsForm.form(htmlContent));
			},
			//添加留言的弹出tingle对话框
			showNewTingleBox:function(htmlContent){
				var  _this  = this;
				// instanciate new modal
				var modal = new tingle.modal({
    				footer: true,
    				stickyFooter: false,
    				cssClass: ['custom-class-1', 'custom-class-2']
    		    });

    		    modal.setContent(htmlContent);

					// add a button
					modal.addFooterBtn('关闭', 'tingle-btn tingle-btn--danger tingle-btn--pull-right', function() {
    					// here goes some logic
    					modal.close();
					});
					// add a button
					modal.addFooterBtn('添加', 'tingle-btn tingle-btn--primary', function() {
    					//激活ajax操作 存储留言
    					var  content 	= $('#content').val();
    					var  type 		= $('#type').val();
    					var  rank 		= $('#rank').val();
    					var  email 		= $('#email').val();

    					$.ajax({
    						url:"{{url('api/message')}}",
    						type:'POST',
    						data:'content='+content+'&type='+type+'&rank='+rank+'&email='+email,
    						dataType:'json',
    						success:function(data){
    							var res 	= data.data;
    							if(res.tag == 'error'){
    								swal({
    									title:"错误提示",
    									text:res.info,
    									html:true
    								});
    								return false;
    							}

    							if(res.tag == 'success'){
    								msgroot.rows 	= res;
    								swal('添加成功','您已成功添加留言','success');
    								modal.close();
    							}
    						}

    					})
					});
					// open modal
					modal.open();
			}
		},
	})
</script>