<div class="col-md-9">

<div class="panel panel-default">
<div class="panel-body">
<p class="tit">申请退货</p>
	<div class="user-info-box">
    {!!Form::open(['url'=>'auth/return/send','method'=>'post','class'=>'form-horizontal','files'=>'true'])!!}
    		
                <div class="form-group">
                <label class="col-sm-2 control-label">选择订单号</label>
                <div class="col-sm-5">
                	<select name="order_id" id="order_id" class="form-control">
                		<option value="">请选择</option>
                		@if($order_list)
                		@foreach($order_list as $item)
                		<option value="{!!$item->id!!}">{!!$item->order_sn!!}</option>
                		@endforeach
                		@endif
                	</select>
                </div>
            </div><!--/form-group-->
                        
            <div class="form-group">
                <label class="col-sm-2 control-label">姓名</label>
                <div class="col-sm-5">
                	<input type="text" name="username" class="form-control" id="username" value="{!!Auth::user('user')->username!!}"  />
                </div>
            </div><!--/form-group-->

            
            <div class="form-group">
                <label class="col-sm-2 control-label">退货类型</label>
                <div class="col-sm-5">
                 	<select name="type" class="form-control">
                 		<option value="0">请选择类型</option>
                 		<option value="全部退货">全部退货</option>
                 		<option value="部分退货">部分退货</option>
                 		<option value="换货">换货</option>
                 	</select>
                </div>
            </div><!--/form-group-->
            
            <div class="form-group">
                <label class="col-sm-2 control-label">退货说明</label>
                <div class="col-sm-5">
                	<textarea name="return_note" rows="8" class="form-control"></textarea>
                </div>
            </div><!--/form-group-->
            <div class="form-group">
                <label class="col-sm-2 control-label">银行名称</label>
                <div class="col-sm-5">
                	<input type="text" name="bank_name" class="form-control" id="bank_name" />
                </div>
            </div><!--/form-group-->
            <div class="form-group">
                <label class="col-sm-2 control-label">银行账号</label>
                <div class="col-sm-5">
                	<input type="text" name="bank_account" class="form-control" id="bank_account" />
                </div>
            </div><!--/form-group-->
            <div class="form-group">
                <label class="col-sm-2 control-label">退货金额</label>
                <div class="col-sm-5">
                	<input type="text" name="return_amount" class="form-control" id="return_amount" />
                </div>
            </div><!--/form-group-->
            <input type="hidden" name="user_id" value="{!!Auth::user('user')->id!!}">
            <input type="hidden" name="reg_from" value="pc版本">
            <div class="form-group">
            	<div class="col-sm-10 col-sm-offset-2">
                	<button type="submit" class="btn btn-success">
                	<span class="glyphicon glyphicon-ok"></span>
                	 {!!trans('front.return_submit')!!}
                	</button>
                	<a href="{!!url('auth/return')!!}" class="btn btn-info">
                		<span class="glyphicon glyphicon-arrow-left"></span>
                		返回列表
                	</a>
                </div>
            </div>
            
    {!!Form::close()!!}
    
	</div><!--/user-info-box-->

</div><!--/panel-body-->
</div><!--/panel-->
</div><!--/col-md-9-->
