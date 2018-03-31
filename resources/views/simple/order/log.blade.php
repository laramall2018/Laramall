@extends('simple.layout.common')
@section('title')
{!!$title!!}
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
{!!HTML::style('static/icheck/skins/all.css')!!}
{!!HTML::script('static/icheck/icheck.js')!!}
{!!HTML::script('files/bootstrap/js/bootstrap.min.js')!!}
{!!HTML::script('files/jquery.confirm.js')!!}

<div class="content-box">
<div class="row">
<div class="col-md-12">
    {!!$path_url!!}
</div>
</div><!--/row-->
    
<div class="row">
    <div class="col-md-12">
    <div class="panel panel-success">
        <div class="panel-heading">订单操作日志</div>
        <div class="panel-body">
            {!!Form::open(['url'=>'admin/order/log/batch','method'=>'post','files'=>true,'class'=>'common-form'])!!}
            @if($log_list)
            <table class="table table-bordered table-hover table-striped">
                <tr>
                    <th>
                    <input type="checkbox" class="icheck mycheckbox checkbox" name="select_all">
                    </th>
                    <th style="width:80px;">编号</th>
                    <th>订单号</th>
                    <th>管理员</th>
                    <th>日志内容</th>
                    <th>操作时间</th>
                    <th style="width:80px;">操作</th>
                </tr>
                @foreach($log_list as $log)
                <tr>
                    <td style="width:50px;">
                        <input type="checkbox" name="ids[]" class="icheck mycheckbox checkbox-item" value="{!!$log->id!!}">
                    </td>
                    <td>{!!$log->id!!}</td>
                    <td>{!!$log->order_sn!!}</td>
                    <td>{!!$log->username!!}</td>
                    <td>{!!$log->log!!}</td>
                    <td><?php echo date('Y-m-d',$log->add_time);?></td>
                    <td>
                        <a href="{!!url('admin/order/log/del/'.$log->id)!!}" class="btn btn-danger del-confirm act" data-url="{!!url('admin/order/log/del/'.$log->id)!!}">
                        <i class="fa fa-times"></i>
                            删除
                        </a>
                    </td>
                </tr>
                @endforeach
            </table>
            @endif
            
            <div class="page-ajax-btn">
            {!!$log_list->render()!!}
            </div>
            <p>总记录数：{!!$log_list->total()!!}
            
            <input type="hidden" name="del_type" id="del_type" value="delete">
            <div class="form-group">
            <span class="btn del-btn btn-danger" data-value="delete">
                <i class="fa fa-refresh"></i>
                批量删除
            </span>
            </div>
            {!!Form::close()!!}
        </div><!--/body-->
    </div><!--/panel-->
    </div><!--/col-md-12-->
</div><!--/row-->
</div><!--/content-box-->
<script type="text/javascript">
	ps.icheckbox();
    ps.privi_checkbox();
	ps.confirm();
	ps.batch();
</script>
@stop