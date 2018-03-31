
<div class="col-md-9">

<div class="panel panel-default">
<div class="panel-heading">
	 
	<h5>
    	<span class="glyphicon glyphicon-th-list"></span>
        <span class="tit">{!!trans('front.order_list')!!}</span>
    </h5>
 </div>

<div class="panel-body">

	<table class="table table-bordered table-hover">
    	
        <tr>
        	<th>{!!trans('front.order_sn')!!}</th>
            <th>{!!trans('front.order_amount')!!}</th>
            <th>{!!trans('front.order_status')!!}</th>
            <th style="width:200px;">{!!trans('front.operation')!!}</th>
        </tr>
        @if($order_list)
        @foreach($order_list as $item)
        <tr>
        	<td>{!!$item->order_sn!!}</td>
            <td>{!!$item->order_amount!!}</td>
            <td>{!!$item['status_str']!!}</td>
            <td>
            	<a class="btn btn-danger btn-cancel" href="{!!url('auth/order/cancel/'.$item->id)!!}">
                <i class="fa fa-times"></i>
                取消
                </a>
                <a class="btn btn-success" href="{!!url('auth/order/preview/'.$item->id)!!}">
                
                查看
                <i class="fa fa-arrow-circle-right"></i>
                </a>
            </td>
        </tr>
        @endforeach
        @endif
        
    
    </table>
    
    <div>
    	{!!$order_list->render()!!}
    </div>

</div><!--/panel-body-->
</div><!--/panel-->
</div><!--/col-md-9-->


