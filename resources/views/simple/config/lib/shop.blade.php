
<div class="ps-tab-content-item cur">

    <div class="form-group">
    	<label class="col-md-3 control-label">网店名称</label>
        <div class="col-md-4">
        	<input type="text" name="shop_name" class="form-control" id="shop_name" value="{!!$row['shop_name']!!}" />
        </div>
    </div><!--/form-group-->
    <div class="form-group">
    	<label class="col-md-3 control-label">网店标题</label>
        <div class="col-md-4">
        	<input type="text" name="shop_title" class="form-control" id="shop_title"  value="{!!$row['shop_title']!!}"/>
        </div>
    </div><!--/form-group-->
    <div class="form-group">
    	<label class="col-md-3 control-label">网店描述</label>
        <div class="col-md-4">
        	<input type="text" name="shop_desc" class="form-control" id="shop_desc" value="{!!$row['shop_desc']!!}" />
        </div>
    </div><!--/form-group-->
    <div class="form-group">
    	<label class="col-md-3 control-label">网店关键词</label>
        <div class="col-md-4">
        	<input type="text" name="shop_keywords" class="form-control" id="shop_keywords" value="{!!$row['shop_keywords']!!}" />
        </div>
    </div><!--/form-group-->

    <div class="form-group">
    	<label class="col-md-3 control-label">网店详细地址</label>
        <div class="col-md-4">
        	<input type="text" name="shop_address" class="form-control" id="shop_address"  value="{!!$row['shop_address']!!}"/>
        </div>
    </div><!--/form-group-->

    <div class="form-group">
    	<label class="col-md-3 control-label">QQ客服</label>
        <div class="col-md-4">
        	<input type="text" name="qq" class="form-control" id="qq" value="{!!$row['qq']!!}" />
        </div>
    </div><!--/form-group-->
    <div class="form-group">
    	<label class="col-md-3 control-label">微信公共号</label>
        <div class="col-md-4">
        	<input type="text" name="weixin" class="form-control" id="weixin" value="{!!$row['weixin']!!}" />
        </div>
    </div><!--/form-group-->
    <div class="form-group">
    	<label class="col-md-3 control-label">客服电话</label>
        <div class="col-md-4">
        	<input type="text" name="tel" class="form-control" id="tel" value="{!!$row['tel']!!}" />
        </div>
    </div><!--/form-group-->
    <div class="form-group">
    	<label class="col-md-3 control-label">电子邮件</label>
        <div class="col-md-4">
        	<input type="text" name="email" class="form-control" id="email" value="{!!$row['email']!!}" />
        </div>
    </div><!--/form-group-->
		<div class="form-group">
    	<label class="col-md-3 control-label">绑定域名</label>
        <div class="col-md-4">
        	<input type="text" name="domain" class="form-control" id="domain" value="{!!$row['domain']!!}" />
        </div>
    </div><!--/form-group-->

    <div class="form-group">
    	<label class="col-md-3 control-label">关闭网店</label>
        <div class="col-md-4">

        	<input type="radio" class="mycheckbox" name="shop_closed" value="0" @if($row['shop_closed'] == 0) checked="checked" @endif  />否
            <input type="radio" class="mycheckbox" name="shop_closed" value="1" @if($row['shop_closed'] == 1) checked="checked" @endif />是
        </div>
    </div><!--/form-group-->
    <div class="form-group">
    	<label class="col-md-3 control-label">关闭原因</label>
        <div class="col-md-4">
    		<textarea class="form-control" name="shop_closed_note" rows="5">{!!$row['shop_closed_note']!!}</textarea>
        </div><!--/col-md-4-->
    </div>

    <div class="form-group">
    	<label class="col-md-3 control-label">关闭注册</label>
        <div class="col-md-4">
        	<input type="radio" class="mycheckbox" name="register_closed" value="0" @if($row['register_closed'] == 0) checked="checked" @endif />不关闭
            <input type="radio" class="mycheckbox" name="register_closed" value="1" @if($row['register_closed'] == 1) checked="checked" @endif />关闭注册
        </div>
    </div><!--/form-group-->



    <div class="form-group">
    	<label class="col-md-3 control-label">网站logo</label>
        <div class="col-md-4">
        	<input type="file" name="shop_logo" id="shop_logo" />
        </div>
    </div><!--/form-group-->
    @if($row['shop_logo'])
    <div class="form-group">
    	<div class="col-md-offset-3 col-md-2">
        	<img src="{!!url($row['shop_logo'])!!}" class="img-thumbnail" />
        </div>
    </div>
    @endif

    <div class="form-group">
    	<label class="col-md-3 control-label">网站公告</label>
        <div class="col-md-4">
    		<textarea class="form-control" name="shop_notices" id="shop_notices" rows="5">{!!$row['shop_notices']!!}</textarea>
        </div><!--/col-md-4-->
    </div>

    <div class="form-group">
    	<label class="col-md-3 control-label">用户中心公告</label>
        <div class="col-md-4">
    		<textarea class="form-control" name="user_notices" id="user_notices" rows="5">{!!$row['user_notices']!!}</textarea>
        </div><!--/col-md-4-->
    </div>


</div><!--/ps-tab-content-item-->
