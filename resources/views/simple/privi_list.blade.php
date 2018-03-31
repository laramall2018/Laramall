@extends('simple.layout.common')
@section('title')
{!!$title!!}
@stop

@section('description')
{!!$description!!}
@stop

@section('script')
{!!HTML::style('static/icheck/skins/all.css')!!}
{!!HTML::script('static/icheck/icheck.js')!!}
{!!HTML::script('files/bootstrap/js/bootstrap.min.js')!!}
{!!HTML::script('files/jquery.confirm.js')!!}
@stop

@section('keywords')
{!!$keywords!!}
@stop

@section('appname')
{!!$appname!!}
@stop


@section('content')


<div class="content-box">

	<div class="row">
	<div class="col-md-12">
					<div class="note note-success">
                        {!!HTML::link('admin/privi/create','添加权限',['class'=>'btn btn-success'])!!}
                        <a href="{!!url('admin/privi/create-batch')!!}" class="btn btn-success">
                        	<i class="fa fa-bars"></i>批量添加
                        </a>
					</div><!--/note-->
					
                    
                    @foreach($privi_list as $privi)
                    
                    
                    
					<div class="panel panel-success offset-top panel-privi-box">
                        
						<div class="panel-heading">
							<div class="row">
                            
                            	<div class="col-md-4">
										<i class="fa fa-cogs"></i>
                                		<input type="checkbox" 
                                	   	name="ids[]" 
                                       	value="{!!$privi->id!!}"
                                       	data-value="{!!$privi->privi_code!!}"
                                        class="icheck privi_checkbox" 
                                       	data-checkbox="icheckbox_square-orange" />
                                       {!!$privi->privi_name!!}[{!!$privi->privi_code!!}]
                                 </div>
                            
							
                            
								
                               <div class="col-md-4 col-md-offset-4 text-right">
                            	<a href="{!!url('admin/privi/'.$privi->id.'/edit')!!}"><i class="fa fa-edit"></i>编辑</a>
                                <a class="del-confirm"
                                 href="{!!url('admin/privi/del/'.$privi->id)!!}"
                                 data-url="{!!url('admin/privi/del/'.$privi->id)!!}"
                                 
                                 >
                                 <i class="fa fa-times"></i>删除</a>
                              </div>
                              </div>
                            
						</div>
                        
						<div class="panel-body">
							<div class="table-scrollable">
                                
								<table class="table table-striped table-bordered table-hover">
								
								<tr>
                                
                                	<th scope="col" class="tit">编号</th>
									
									<th scope="col">
										 权限名称
									</th>
                                    <th scope="col">
										 路由名称
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
                                    	
                                        
                                        <a href="{!!url('admin/privi/'.$item->id.'/edit')!!}" class="btn btn-success">
                                        	<i class="fa fa-edit"></i>编辑
                                        </a>
                                        <a href="{!!url('admin/privi/del/'.$item->id)!!}" 
                                        	class="btn btn-danger del-confirm" 
                                            data-url="{!!url('admin/privi/del/'.$item->id)!!}"
                                            
                                            >
                                        	<i class="fa fa-trash-o"></i>删除
                                        </a>
                                    </td>
                                 </tr>
                                @endforeach
                                
								</table>
                                
							</div>
						</div>
                        
					</div><!--/portlet-->
                    
                    @endforeach
                    
                    
                    {!!$privi_list->render()!!}
                    
                   
					
    </div><!--/col-md-12-->
</div><!--/row-->

</div>
<script type="text/javascript">
	ps.icheckbox();
    ps.privi_checkbox();
	ps.confirm();
	ps.panel();
</script>
	
@stop