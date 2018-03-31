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


<div class="row">
	<div class="col-md-12">
					<div class="note note-success">
                        {!!HTML::link('/privi/add','添加权限',['class'=>'btn red'])!!}
					</div><!--/note-->
					
                    
                    @foreach($privi_list as $privi)
                    
					<div class="portlet box green">
                        
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-cogs"></i>
                                <input type="checkbox" 
                                	   name="ids[]" 
                                       value="{!!$privi->id!!}"
                                       data-value="{!!$privi->privi_code!!}"
                                        class="icheck privi_checkbox" 
                                       data-checkbox="icheckbox_square-orange" />
                                       {!!$privi->privi_name!!}[{!!$privi->privi_code!!}]
							</div>
                            
							<div class="tools">
                                <a href="javascript:;" class="collapse">
								</a>
								<a href="{!!url('privi/edit/'.$privi->id)!!}" class="act" style="color:#fff;">
                                        	<i class="fa fa-edit"></i>编辑
                                        </a>
                                        <a href="{!!url('privi/del/'.$privi->id)!!}" 
                                        	class=" del-confirm" 
                                            data-url="{!!url('privi/del/'.$privi->id)!!}"
                                            
                                             style="color:#fff;">
                                        	<i class="fa fa-trash-o"></i>删除
                                        </a>
							</div>
						</div>
                        
						<div class="portlet-body">
							<div class="table-scrollable">
                                
								<table class="table table-striped table-bordered table-hover">
								<thead>
								<tr>
                                
                                	<th scope="col" class="tit">编号</th>
									
									<th scope="col">
										 权限名称
									</th>
                                    <th scope="col">
										 权限代码
									</th>
                                    <th scope="col">
                                    	权限路由
                                    </th>
                                    <th scope="col">
                                    	所属权限
                                    </th>
									
									<th scope="col" style="width:200px; text-align:center;">
										 相关操作
									</th>
									
								</tr>
								</thead>
								<tbody>
                                
                                
                                
                                @foreach($privi['child'] as $item)
                                <tr>
                                	
                                    
                                    <td class="tit">
                                    	<input type="checkbox" 
                                        	   name="ids[]" 
                                               value="{!!$item->id!!}" 
                                               data-parent="{!!$privi->privi_code!!}"
                                               class="icheck mycheckbox {!!$privi->privi_code!!}_item"
                                                />
                                    	{!!$item->id!!}
                                    </td>
                                    <td>{!!$item->privi_name!!}</td>
                                    <td>{!!$item->privi_code!!}</td>
                                    
                                    <td>{!!$item->privi_route!!}</td>
                                    <td>{!!$privi->privi_name!!}</td>	
                                    
                                    <td style="text-align:center;">
                                    	
                                        
                                        <a href="{!!url('privi/edit/'.$item->id)!!}" class="btn default  purple">
                                        	<i class="fa fa-edit"></i>编辑
                                        </a>
                                        <a href="{!!url('privi/del/'.$item->id)!!}" 
                                        	class="btn default  black del-confirm" 
                                            data-url="{!!url('privi/del/'.$item->id)!!}"
                                            
                                            >
                                        	<i class="fa fa-trash-o"></i>删除
                                        </a>
                                    </td>
                                 </tr>
                                @endforeach
                                
                                </tbody>
								</table>
                                
							</div>
						</div>
                        
					</div><!--/portlet-->
                    
                    @endforeach
                    
                    
                    {!!$privi_list->render()!!}
                    
                   
					
    </div><!--/col-md-12-->
</div><!--/row-->

    

	
@stop