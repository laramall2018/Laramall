
<div class="container">
<div class="row">
<div class="col-sm-6 col-sm-offset-3">

<div class="panel panel-success">
<div class="panel-heading">
 <h5>{!!trans('front.supplier_login')!!}</h5>
</div>

<div class="panel-body">

    {!!Form::open(['url'=>'supplier/login','method'=>'post','class'=>'supplier-form form-horizontal'])!!}
    	
        
        <div class="form-group">
        	<label class="control-label col-sm-3">{!!trans('front.supplier_email')!!}</label>
        	<div class="col-sm-6">
            	<input type="text" name="email" id="email" class="form-control" />
            </div>
        </div>
        
        <div class="form-group">
        	<label class="control-label col-sm-3">{!!trans('front.supplier_password')!!}</label>
        	<div class="col-sm-6">
            	<input type="password" name="password" id="password" class="form-control" />
            </div>
        </div>
        <div class="form-group">
        	<div class="col-sm-6 col-sm-offset-3">
            	<button type="submit" class="btn btn-success btn-lg">
                	{!!trans('front.submit_login')!!}
                    <span class="glyphicon glyphicon-circle-arrow-right"></span>
                </button>
            </div>
        </div>
    
    {!!Form::close()!!}
    
</div><!--/panel-body-->
</div><!--/panel-->

</div><!--/col-sm-6-->
</div><!--/row-->
</div><!--/container-->
