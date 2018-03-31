
<div class="col-md-9">

<div class="panel panel-default">
<div class="panel-heading">
	 
	<h5>
    	<span class="glyphicon glyphicon-th-list"></span>
        <span class="tit">{!!trans('front.return_detail')!!}</span>
    </h5>
 </div>

<div class="panel-body">
    
   
	<table class="table table-bordered table-hover table-striped">
        
        <tr>
            <th>订单号</th>
            <td>
                <a href="{!!url('auth/order/preview/'.$model->order_id)!!}" target="_blank">
                {!!$model->order->order_sn!!}
                </a>
            </td>
            <th>退货人</th>
            <td>{!!$model->username!!}</td>
        </tr>
        <tr>
            <th>退货类型</th>
            <td>{!!$model->type!!}</td>
            <th>退货说明</th>
            <td>{!!$model->return_note!!}</td>
        </tr>
        <tr>
            <th>银行信息</th>
            <td>{!!$model->bank_name!!}</td>
            <th>银行账号</th>
            <td>{!!$model->bank_account!!}</td>
        </tr>
        <tr>
            <th>退款金额</th>
            <td class="org">{!!$model->return_amount!!}</td>
            <th>退货状态</th>
            <td>
                {{$model->status()}}
            </td>
        </tr>
        <tr>
            <th>申请时间</th>
            <td>{{$model->time()}}</td>
            <th>申请来源</th>
            <td>{{$model->reg_from}}</td>
        </tr>
        
    
    </table>

    @include('matrix.lib.user.return_order_goods')
   

</div><!--/panel-body-->
</div><!--/panel-->


<a href="{!!url('auth/return')!!}" class="btn btn-success">
	<i class="fa fa-arrow-circle-o-left"></i>
	{!!trans('front.back_to_return_list')!!}
</a>

</div><!--/col-md-9-->
