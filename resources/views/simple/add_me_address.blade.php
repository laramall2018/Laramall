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
	
    
    <div class="content-box">
    	<div class="row">
    	<div class="col-md-12">
        	{!!$path_url!!}
        </div>
    	</div>
       
       <div class="panel panel-primary">
       		<div class="panel-heading">
            	<span>{!!$action_name!!}</span>
            </div>
            <div class="panel-body">
            	
                <form class="form-horizontal" method="post" action="{!!url('admin/me_address')!!}" enctype="multipart/form-data">
  					<input type="hidden" name="_token" value="{!!csrf_token()!!}" />
            
        			
                    
                    <div class="form-group">
    					<label for="address" class="col-md-2 control-label">国家省会信息</label>
    					<div class="col-md-10">
      						<select name="province" id="province">
                            	{!!$province_list!!}
                            </select>
    					   
      						<select name="city" id="city">
                            	
                            </select>
    						
      						<select name="district" id="district">
                            	
                            </select>
    					</div>
                        
                        
  			 		</div>
                    
                    <div class="form-group">
    					<label for="address" class="col-sm-2 control-label">详细地址</label>
    					<div class="col-sm-6">
      					<input type="text" class="form-control" id="address" name="address" placeholder="机构地址信息">
    					</div>
  			 		</div>
                    <div class="form-group">
                    	<label for="mechanism_id" class="col-sm-2 control-label">所属机构</label>
                        <div class="col-sm-6">
      						<select name="mechanism_id" id="mechanism_id">
                            	<option value="0">请选择所属机构</option>
                            </select>
    					</div>
                    
                    </div>
            
            
            	<div class="form-group">
    				<div class="col-sm-offset-2 col-sm-6">
      				<button type="submit" class="btn btn-success">确认添加</button>
    			</div>
  	</div>
  
  
  
		</form>
                
                
            </div>
       
       </div>
    </div>
    
<script type="text/javascript">
 $(function(){
	 ps.province_city_district_ajax("{!!$ajax_url!!}","{!!csrf_token()!!}");
 });
</script>

@stop