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
	
    
    <div class="content">
    	
        
        <div class="row">
        	{!!Form::open(['url'=>'admin/article/batch','method'=>'post','files'=>true,'class'=>'common-form'])!!}
			<div class="col-md-12">
					<div class="alert alert-block alert-info fade in">
						
                        
                        {!!HTML::link('admin/article/add','添加新闻',['class'=>'btn red'])!!}
                      
					</div>
					
					<div class="portlet box green">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-cogs"></i>新闻列表
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
                                    	
                                       <input type="checkbox" name="select_all" class="icheck mycheckbox" />
                                       
                                    </th>
									<th scope="col">
										 新闻编号
									</th>
									<th scope="col">
										 新闻标题
									</th>
                                    <th scope="col">
										 新闻分类
									</th>
									<th scope="col">
										 添加时间
									</th>
									<th scope="col">
										 相关操作
									</th>
									
								</tr>
								</thead>
								<tbody>
                                @foreach($article_list as $article)
                                	<tr>
                                    <td class="tit">
                              			<input type="checkbox" name="ids[]" value="{!!$article->id!!}" class="icheck mycheckbox checkbox-item" />
                                    </td>
                                	<td>{!!$article->id!!}</td>
                                    <td>{!!$article->article_title!!}</td>
                                    <td>{!!$article->cat_id!!}</td>
                                    <td><?php echo date('Y-m-d H:i:s',$article->add_time);?></td>
                                    <td class="tit" style="width:180px;">
                                    	<i class="fa fa-edit"></i>
                                        {!!HTML::link('admin/article/edit/'.$article->id,'编辑',['class'=>'act'])!!}
                                        <i class="fa fa-times"></i>
                                        {!!HTML::link('admin/article/del/'.$article->id,'删除',['class'=>'act del-confirm','data-url'=>url('admin/article/del/'.$article->id)])!!}
                                        <i class="fa fa-times"></i>
                                        {!!HTML::link('admin/article/preview/'.$article->id,'查看',['class'=>'act'])!!}
                                    </td>
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