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

{!!Form::open(['url'=>'admin/article_cat/batch','method'=>'post','files'=>true,'class'=>'common-form'])!!}
<div class="row">
	<div class="col-md-12">
					<div class="note note-success">
                        {!!HTML::link('admin/article_cat/add','添加新闻分类',['class'=>'btn red'])!!}
					</div><!--/note-->
					
                    
					<div class="portlet box green">
                        
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-cogs"></i>{!!$controller_name!!}
							</div>
							<div class="tools">
								<a href="javascript:;" class="collapse">
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
									<th scope="col" class="tit">
										 编号
									</th>
									<th scope="col">
										 分类名称
									</th>
                                    <th scope="col">
										 父亲分类
									</th>
                                    <th scope="col">
                                    	分类图标
                                    </th>
									
									<th scope="col" style="width:200px; text-align:center;">
										 相关操作
									</th>
									
								</tr>
								</thead>
								<tbody>
                                @foreach($article_cat_list as $item)
                                <tr>
                                	
                                    <td class="tit">
                                    
                              <input type="checkbox" name="ids[]" value="{!!$item->id!!}" class="icheck mycheckbox checkbox-item" />
                                   
                                       
                                    </td>
                                    <td class="tit">{!!$item->id!!}</td>
                                    <td>{!!$item->cat_name!!}</td>
                                    <td>{!!$item->parent_id!!}</td>
                                    
                                    <td>
                                    	@if($item->cat_pic)
                                        {!!HTML::image($item->cat_pic,'',['class'=>'config-img-mini'])!!}
                                        @endif
                                    </td>
                                    
                                    <td style="text-align:center;">
                                    	
                                        
                                        <a href="{!!url('admin/article_cat/edit/'.$item->id)!!}" class="btn default  purple">
                                        	<i class="fa fa-edit"></i>编辑
                                        </a>
                                        <a href="{!!url('/admin/article_cat/del/'.$item->id)!!}"
                                        	 class="btn default  black del-confirm"
                                             data-url="{!!url('/admin/article_cat/del/'.$item->id)!!}"
                                             >
                                        	<i class="fa fa-trash-o"></i>删除
                                        </a>
                                    </td>
                                 </tr>
                                @endforeach
                                </tbody>
								</table>
							</div>
                            
                            <div class="form-group">
                                <input type="hidden" name="del_type" value="delete" id="del_type" />
                            	<span class="btn red del-btn"  data-value="delete">批量删除</span>
                                <span class="btn blue del-btn" data-value="softdel">回收站</span>
                                
                        	</div>
						</div>
					</div><!--/portlet-->
					
    </div><!--/col-md-12-->
</div><!--/row-->
{!!Form::close()!!}
    

	
@stop