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

@section('script')
{!!HTML::style('static/icheck/skins/all.css')!!}
{!!HTML::script('static/icheck/icheck.js')!!}
{!!HTML::script('files/bootstrap/js/bootstrap.min.js')!!}
{!!HTML::script('files/jquery.confirm.js')!!}
{!!HTML::script('static/js/jquery.json-2.4.js')!!}
{!!HTML::script('static/js/phpstore.grid.js')!!}
@stop


@section('content')

<div class="content-box">

	<div class="row">
    	<div class="col-md-12">
        	{!!$path_url!!}
        </div>
    </div>

    <div class="row">
    <div class="col-md-12 offset-bottom">
        	{!!$add_btn!!}
    </div>
    </div><!--/widget-title-->
    
    <div class="panel panel-primary">
    
    <div class="panel-heading">
    	<div class="caption">
        	ajax搜索
        </div><!--/caption-->
    </div>
    
    <div class="panel-body">
    
    	
          <form class="form-horizontal">
  			<input type="hidden" name="_token" value="{!!csrf_token()!!}" />
            
        	<div class="form-group">
    			<label for="address" class="col-sm-2 control-label">详细地址</label>
    			<div class="col-sm-6">
      			<input type="text" class="form-control" id="address" name="address" placeholder="机构地址信息">
    			</div>
  			</div>
            
            <div class="form-group">
    			<div class="col-sm-offset-2 col-sm-6">
      			<button type="submit" class="btn btn-success">确认搜索</button>
    		</div>
  </div>
  
  
  
		</form>
    
    
    </div>
    </div>
    
    
    
    
     <div class="panel panel-primary">
     	
        <div class="panel-heading">
        	<span>{!!$action_name!!}</span>
        </div>
        <div class="panel-body">
        	
            
            <table class="table table-hover table-bordered">
            	
                <tr>
                	<th>编号</th>
                    <th>国家</th>
                    <th>省会</th>
                    <th>城市</th>
                    <th>地区</th>
                    <th>地址</th>
                    <th>所属机构</th>
                    <th>相关操作</th>
                </tr>
                
                @foreach($address_list as $item)
                <tr>
                	<td>{!!$item->id!!}</td>
                    <td>{!!$item->country_str!!}</td>
                    <td>{!!$item->province_str!!}</td>
                    <td>{!!$item->city_str!!}</td>
                    <td>{!!$item->district_str!!}</td>
                    <td>{!!$item->address!!}</td>
                    <td>{!!$item->mechanisam_id!!}</td>
                
                	<td>
                    	
                        <a class="btn btn-danger" href="{!!url('admin/me_address/'.$item->id)!!}"><i class="fa fa-edit"></i>编辑</a>
                        <a class="btn btn-info del-confirm" href="{!!url('admin/me_address/'.$item->id)!!}"><i class="fa fa-times"></i>删除</a>
                    
                    </td>
                </tr>
                @endforeach
            	
            </table>
            
            
        </div>
     </div><!--/panel-->
     
     {!!$address_list->render()!!}
    
    
    
     
    </div><!--/content-->
    
</div><!--/widget-->
<script type="text/javascript">
	ps.icheckbox();
    ps.privi_checkbox();
	ps.confirm();
	ps.batch();
</script>

@stop

