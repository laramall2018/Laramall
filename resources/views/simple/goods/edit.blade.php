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
{!!HTML::script('static/js/jquery.json-2.4.js')!!}
{!!HTML::script('files/jquery-ui/jquery-ui-1.10.1.custom.js')!!}
{!!HTML::style('files/jquery-ui/start/jquery-ui-1.10.1.custom.css')!!}
<script type="text/javascript">
$(function(){
	
	ps.goods_tab();
});
</script>
<script type="text/javascript">
	$(function() {
		

		
		 $("#promote_start_date,#promote_end_date").mouseover(function() {
                        $.datepicker.regional['zh-CN'] =
                         {

                             clearText: '清除', clearStatus: '清除已选日期',
                             closeText: '关闭', closeStatus: '不改变当前选择',
                             prevText: '&lt;上月', prevStatus: '显示上月',
                             nextText: '下月&gt;', nextStatus: '显示下月',
                             currentText: '今天', currentStatus: '显示本月',
                             monthNames: ['一月', '二月', '三月', '四月', '五月', '六月',
                            '七月', '八月', '九月', '十月', '十一月', '十二月'],
                             monthNamesShort: ['一', '二', '三', '四', '五', '六',
                            '七', '八', '九', '十', '十一', '十二'],
                             monthStatus: '选择月份', yearStatus: '选择年份',
                             weekHeader: '周', weekStatus: '年内周次',
                             dayNames: ['星期日', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六'],
                             dayNamesShort: ['周日', '周一', '周二', '周三', '周四', '周五', '周六'],
                             dayNamesMin: ['日', '一', '二', '三', '四', '五', '六'],
                             dayStatus: '设置 DD 为一周起始', dateStatus: '选择 m月 d日, DD',
                             dateFormat: 'yy-mm-dd', firstDay: 1,
                             initStatus: '请选择日期', isRTL: false

                         };
                        $.datepicker.setDefaults($.datepicker.regional['zh-CN']);
                        $(this).datepicker();
                    });
	});
</script>
	
    <div class="content-box">
    <div class="row">
    	<div class="col-md-12">
        {!!$path_url!!}
        </div>
    </div><!--/row-->
    
    <div class="row">
    <div class="col-md-12">
       
        <div class="panel panel-primary">
			<div class="panel-heading">
				<div class="caption">
					<i class="fa fa-cog"></i>{!!$action_name!!}
				</div>
			</div><!--/panel-heading-->
			
            <div class="panel-body">
			    
               <div class="ps-tab">
                  
                   
                   {!!Form::open(['url'=>'admin/goods/'.$model->id,'method'=>'post','files'=>true,'class'=>'form-horizontal'])!!}
                   
                    <ul class="ps-tab-title">
                    	<li class="cur">基本信息</li>
                        <li>详情描述</li>
                        <li>商品相册</li>
                        <li>其他信息</li>
                        <li>商品属性</li>
                        <li>商品规格</li>
                        <li>关联商品</li>
                        <li>关联新闻</li>
                    </ul>
                    
                    <div class="ps-tab-content">
                    		
                        @include('simple.goods.lib.base_edit')
                        @include('simple.goods.lib.ueditor_edit')
                        @include('simple.goods.lib.gallery_edit')
                        @include('simple.goods.lib.other_edit')
                        @include('simple.goods.lib.attr_edit')
                        @include('simple.goods.lib.field_edit')
                        @include('simple.goods.lib.goods_edit')
                        @include('simple.goods.lib.article_edit')
                    </div>
                        
                        <div class="alert alert-success">
                        	所有信息都添加完毕后 再递交确认按钮
                        </div>
                    	<div class="form-group">
                        	<div class="col-md-offset-3 col-md-9">
                                <input type="hidden" name="id" value="{!!$model->id!!}" />
                                <input type="hidden" name="_method" value="PUT" />
                            	<input type="submit" name="submit" class="btn btn-primary" value="确认编辑" />
                                <a href="{!!url('admin/goods')!!}" class="btn btn-danger">返回</a>
                            </div>
                        </div><!--/form-group-->              
               		{!!Form::close()!!}
               </div><!--/ps-tab-->
               
			</div><!--/portlet-body-->
                                    
		</div><!--/portlet-->
													
    </div><!--/col-md-12-->
    </div><!--/row-->
    </div><!--/content-box-->
@stop