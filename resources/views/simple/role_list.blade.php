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
	
    
    <div class="content-box">
    	
       {!!$path_url!!}
    	           <div class="alert alert-block alert-info fade in">
                               {!!HTML::link('/admin/role/add','添加管理员',['class'=>'btn blue'])!!}
                    </div>
       <div class="panel panel-success">
  					<div class="panel-heading">{!!$action_name!!}</div>
  					<div class="panel-body">
    					<table class="table table-striped table-bordered table-hover">
                                        	<tr>
                                            	<th>编号</th>
                                                <th>角色</th>
                                                <th>相关操作</th>
                                            </tr>
                                        	@foreach($role_list as $item)
                                        	<tr>
                                            	<td>{!!$item->role_id!!}</td>
                                                <td>{!!$item->role_name!!}</td>
                                                <td>
                            <a class="btn" href="{!!url('admin/role/edit/'.$item->role_id)!!}"><i class="fa fa-edit"></i>编辑</a>
                            <a class="btn" href="{!!url('admin/role/del/'.$item->role_id)!!}">删除</a>
                                                </td>	
                                            </tr>
                                        	@endforeach
                                        
                                        </table>
  					</div>
				</div>
                
    </div>
@stop