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
<link href="{!!url('files/bootstrap/css/buttons.css')!!}" type="text/css" rel="stylesheet" />
	<div class="content-box">
    
		
    
    	<div class="row">
    	<div class="col-md-12">
        
        
        
    	<div class="panel panel-success">
        	
             <div class="panel-heading">
             		<div class="caption">
                    	<i class="fa fa-home"></i>
                        phpstore介绍说明
                    </div>
             </div>
             <div class="panel-body">
             		
                    <p>PhpStore是全网首款基于laravel框架全新研发的新一代商城系统</p>
                    <p>系统支持数据库包括：mysql redis mongodb等</p>
                    <p>基于laravel框架内核的phpstore不仅功能强大易用而且非常方便二次开发。推出初期就获得了成千上万用户的热捧和喜爱。</p>
                    <p>官网：<a href="http://www.prorigine.com">www.prorigine.com</a></p>
                    
                
             </div>
        
        </div><!--/portlet-->
    	
        </div><!--/col-md-12-->
        
        <div class="col-md-12">
        
    	<div class="panel panel-info">
        	
             <div class="panel-heading">
             		<div class="caption">
                    	<i class="fa fa-home"></i>
                        系统信息
                    </div>
            
             </div>
             <div class="panel-body">
             		
                    <div class="table-responsive">
                    	
                        <table class="table table-striped table-bordered table-hover">
                        	<tbody>
                            	<tr>
                                	<td>操作系统</td>
                                    <td>{!!$system_info['os']!!}</td>
                                    <td>web服务器</td>
                                    <td>{!!$system_info['web_server']!!}</td>
                                </tr>
                                <tr>
                                	<td>php版本</td>
                                    <td>{!!$system_info['phpversion']!!}</td>
                                    <td>mysql版本</td>
                                    <td>{!!$system_info['mysql']!!}</td>
                                </tr>
                                <tr>
                                	<td>程序名称</td>
                                    <td>{!!$system_info['appname']!!}</td>
                                    <td>是否安全模式</td>
                                    <td>{!!$system_info['safe_mode']!!}</td>
                                </tr>
                                <tr>
                                	<td>安装时间</td>
                                    <td>{!!$system_info['created_at']!!}</td>
                                    <td>上传文件最大尺寸</td>
                                    <td>{!!$system_info['upload_max_filesize']!!}</td>
                                </tr>
                                <tr>
                                	<td>laravel版本</td>
                                    <td>{!!$system_info['version']!!}</td>
                                    <td>时区</td>
                                    <td>{!!$system_info['timezone']!!}</td>
                                </tr>
                            </tbody>
                        </table>
                    
                    </div><!--/table-->
             </div>
        
        </div><!--/portlet-->
    	
        </div><!--/col-md-12-->
        
        
    </div><!--/row-->
    
    	<div class="row">
        	
            <div class="panel panel-success">
            	<div class="panel-heading">快捷操作</div>
                <div class="panel-body">
                    {!!$links!!}
                </div><!--/panel-body-->
            </div><!--/panel-->
        
        </div>
    
    </div><!--/content-box-->
@stop