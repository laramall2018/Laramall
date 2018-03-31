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
				<div class="col-md-12">
					<div class="note note-success">
						
                        
                        {!!$model->article_title!!}
                      
					</div>
				</div>
	  </div> <!--/row-->
      
      	<div class="portlet box blue">
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
							
      						{!!$model->article_content!!}
                        
                        	<div class="form-group">
                         <pre class="prettyprint linenums" style="font-size:20px;">
         					{!!$model->article_code!!}
         				</pre>
                        </div>
                        
                            <a href="{!!$back_url!!}" class="btn red">返回</a>
                            <a href="{!!$edit_url!!}" class="btn blue">编辑</a>
                        
                        </div>
      </div>
       
    </div>
@stop