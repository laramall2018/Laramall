@extends('phpstore.layout.common')
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
	
    
    <div>
    	
        
        <div class="row">
            
        	{!!Form::open(['url'=>'privi/role/batch','method'=>'post','files'=>true,'class'=>'common-form'])!!}
			<div class="col-md-12">
					
					<div class="alert alert-block alert-info fade in">
                               {!!HTML::link('privi/role/add','添加角色',['class'=>'btn blue'])!!}
		            </div>
					<div class="portlet box green">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-cogs"></i>{!!$action_name!!}
							</div>
							<div class="tools">
								<a href="javascript:;" class="collapse">
								</a>
								<a href="#portlet-config" data-toggle="modal" class="config">
								</a>
								<a href="javascript:;" class="reload">
								</a>
								<a href="javascript:;" class="remove">
								</a>
							</div>
						</div>
						<div class="portlet-body">
							
                            
                            <div class="table-scrollable">
								<table class="table table-striped table-bordered table-hover">
								<thead>
								<tr>
                                	<th scope="col" class="tit">
                                    	
                                       <input type="checkbox" data-checkbox="icheckbox_square-green" name="select_all" class="icheck mycheckbox" />
                                       
                                    </th>
									<th scope="col">
										 编号
									</th>
									<th scope="col">
										 名称
									</th>
									<th scope="col">
										 相关操作
									</th>
									
								</tr>
								</thead>
								<tbody>
                                @foreach($role_list as $item)
                                	<tr>
                                    <td class="tit">
                              			<input type="checkbox" name="ids[]" value="{!!$item->role_id!!}" class="icheck mycheckbox checkbox-item" />
                                    </td>
                                    <td>{!!$item->role_id!!}</td>
                                	<td>{!!$item->role_name!!}</td>
                                    <td class="tit" style="width:200px;">
                                    	<i class="fa fa-edit"></i>
                                        {!!HTML::link('privi/role/edit/'.$item->role_id,'编辑',['class'=>'act'])!!}
                                        <i class="fa fa-times"></i>
                                        {!!HTML::link('privi/role/del/'.$item->role_id,'删除',['class'=>'act del-confirm','data-url'=>url('privi/role/del/'.$item->role_id)])!!}
                                        
                                       
                                    </tr>
                                @endforeach
                                </tbody>
								</table>
							</div>
                            
                            <div class="form-group">
                                <input type="hidden" name="del_type" value="delete" id="del_type" />
                            	<span class="btn red del-btn"  data-value="delete">批量删除</span>    
             				</div>
                            
						</div><!--/portlet-body-->
					</div>
					
				</div>
                
             
            {!!Form::close()!!}
		</div>
    
    </div>
@stop