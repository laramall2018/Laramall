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
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat blue-madison">
						<div class="visual">
							<i class="fa fa-comments"></i>
						</div>
						<div class="details">
							<div class="number">
								 1349
							</div>
							<div class="desc">
								系统商品数量
							</div>
						</div>
						<a class="more" href="{!!url('admin/goods')!!}">
						查看详情 <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat red-intense">
						<div class="visual">
							<i class="fa fa-bar-chart-o"></i>
						</div>
						<div class="details">
							<div class="number">
								 1222单
							</div>
							<div class="desc">
								 订单总数
							</div>
						</div>
						<a class="more" href="javascript:;">
						查看详情 <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat green-haze">
						<div class="visual">
							<i class="fa fa-shopping-cart"></i>
						</div>
						<div class="details">
							<div class="number">
								 549
							</div>
							<div class="desc">
								 最新订单
							</div>
						</div>
						<a class="more" href="javascript:;">
						查看详情 <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat purple-plum">
						<div class="visual">
							<i class="fa fa-globe"></i>
						</div>
						<div class="details">
							<div class="number">
								 12322
							</div>
							<div class="desc">
								 会员总数
							</div>
						</div>
						<a class="more" href="javascript:;">
						查看详情 <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
			</div>
    
    <div class="row">
    	<div class="col-md-12">
        
    	<div class="portlet box blue">
        	
             <div class="portlet-title">
             		<div class="caption">
                    	<i class="fa fa-home"></i>
                        phpstore介绍说明
                    </div>
                    <div class="tools">
                    	<a class="collapse" href="javascript:;" data-original-title="" title=""></a>
                    </div><!--/tools-->
             </div>
             <div class="portlet-body">
             		
                    <p>phpstore是北京麦维创想科技有限公司基于laravel框架全新研发的新一代商城系统</p>
                    <p>系统支持数据库包括：mysql redis mongodb等</p>
                    <p>基于laravel框架内核的phpstore不仅功能强大易用而且非常方便二次开发。推出初期就获得了成千上万用户的热捧和喜爱。</p>
                    
                
             </div>
        
        </div><!--/portlet-->
    	
        </div><!--/col-md-12-->
        
        <div class="col-md-12">
        
    	<div class="portlet box red">
        	
             <div class="portlet-title">
             		<div class="caption">
                    	<i class="fa fa-home"></i>
                        系统信息
                    </div>
                    <div class="tools">
                    	<a class="collapse" href="javascript:;" data-original-title="" title=""></a>
                    </div><!--/tools-->
             </div>
             <div class="portlet-body">
             		
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
@stop