{!!Form::open(['url'=>'supplier/update','method'=>'post','class'=>'supplier-form form-horizontal'])!!}
    	
        <div class="form-group">
        	<label class="control-label col-sm-3">{!!trans('front.supplier_username')!!}</label>
        	<div class="col-sm-6">
            	<input type="text" name="username" id="username" class="form-control" value="{!!Auth::user('supplier')->username!!}" />
            </div>
        </div>
        <div class="form-group">
        	<label class="control-label col-sm-3">{!!trans('front.supplier_email')!!}</label>
        	<div class="col-sm-6">
            	<input type="text" name="email" id="email" class="form-control" value="{!!Auth::user('supplier')->email!!}" />
            </div>
        </div>
        <div class="form-group">
        	<label class="control-label col-sm-3">{!!trans('front.supplier_phone')!!}</label>
        	<div class="col-sm-6">
            	<input type="text" name="phone" id="phone" class="form-control"  value="{!!Auth::user('supplier')->phone!!}"/>
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
            	<button type="submit" class="btn btn-success">
                	{!!trans('front.update')!!}
                    <span class="glyphicon glyphicon-circle-arrow-right"></span>
                </button>
            </div>
        </div>
    
    {!!Form::close()!!}