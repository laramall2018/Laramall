
<div class="row top">
	
    <div class="col-md-2">
    	<img class="img-rounded logo" src="{!!url('static/img/phpstore2.png')!!}" />
    </div><!--/col-md-2-->
    
    <div class="col-md-10">
    	<div class="dropdown right-link">
  			<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    @if(Auth::user())
    {!!Auth::user()->username!!}
    @else
    未登录
    @endif
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">
    <li><a href="#">系统信息</a></li>
    <li><a href="#"><i class="fa fa-key"></i>退出登录</a></li>
  </ul>
    </div>
</div>


</div>