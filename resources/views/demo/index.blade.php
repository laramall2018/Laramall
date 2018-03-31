<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>{{$title}}</title>
<link rel="stylesheet" type="text/css" href="{!!url('front/matrix/bootstrap/css/bootstrap.min.css')!!}"/>
<link rel="stylesheet" type="text/css" href="{!!url('front/matrix/font-awesome/css/font-awesome.min.css')!!}"/>
<link rel="stylesheet" type="text/css" href="{!!url('front/matrix/demo.css')!!}"/>
<link id="color-css-btn" rel="stylesheet" type="text/css" href="{!!url('front/matrix/blue.css')!!}"/>
<script type="text/javascript" src="{!!url('front/matrix/js/jquery.min.js')!!}"></script>
<script type="text/javascript" src="{!!url('front/matrix/js/jquery.json-2.4.js')!!}"></script>
<script type="text/javascript" src="{!!url('front/matrix/js/front.js')!!}"></script>
<script type="text/javascript" src="{!!url('front/matrix/js/jquery.animate-colors.js')!!}"></script>
<script type="text/javascript" src="{!!url('files/jquery.confirm.js')!!}"></script>
<script type="text/javascript" src="{!!url('front/matrix/js/jquery.cookie.js')!!}"></script>
</head>
<body>

      <div class="top">
      <div class="top-bb">

      <h3>
        PHPStore商城系统演示站 查看演示请输入访问密码!密码请向管理员索取!
      </h3>
      <a href="http://www.prorigine.com/contact" class="demo-btn btn btn-success btn-lg" target="_blank">
        <span class="glyphicon glyphicon-zoom-in"></span>
        点击查看联系方式
      </a>

      @if(Auth::check('demo'))
      <a class="demo-btn btn btn-lg btn-info" href="{!!url('/')!!}">
        <span class="glyphicon glyphicon-camera"></span>
        查看演示
      </a>
          <a class="demo-btn btn btn-lg btn-danger" href="{!!url('demo/logout')!!}">
            <span class="glyphicon glyphicon-lock"></span>
            登出
          </a>
      @else
      {!!Form::open(['url'=>'demo','method'=>'post','class'=>'demo-form'])!!}

          <input type="text" name="password" id="password" class="password-input" placeholder="请输入访问密码" value="demo888">
          <button type="submit" class="btn-submit">
            <i class="fa fa-arrow-right"></i>
          </button>

      {!!Form::close()!!}
      @endif
      </div><!--/top-bb-->
      </div><!--/top-->
      <div class="middle">
        <h2>相关技术说明</h2>
        <div class="btn-tit">【1】前后台兼容主流浏览器 ie9+,firefox,chrome,safari,360(最新版)等！不再支持低版本浏览器</div>
        <img src="{!!url('front/images/ie.png')!!}" style="width:800px;">

        <div class="btn-tit">【2】首页增加配色选择器 集成12种颜色 后台可以轻松定制颜色</div>
        <div class="row">
          <div class="col-md-6">
          <img src="{!!url('front/images/color-front.png')!!}" class="img-thumbnail">
          </div>
          <div class="col-md-6">
              <p>前台内置12种配色可以轻松切换配色</p>
              <p>选中的配色 系统会智能记住配色 进入其他页面也会保留该配色方案</p>
          </div>
        </div><!--/row-->
        <div class="row" style="margin:10px 0;">

        <div class="col-md-6">
        <img src="{!!url('front/images/color2.png')!!}" class="img-thumbnail">

        </div>
        <div class="col-md-6">
            <p>后台可以自定义配色 修改配色颜色和样式</p>
            <p>前后台已经完美对接 可以轻松添加和修改配色 并在前台切换</p>
        </div>

        </div><!--/row-->

        <div class="btn-tit">【3】商品列表页可以轻松切换商品缩略图 并直接把商品加入到购物车</div>
        <div class="row" style="margin:10px 0;">

        <div class="col-md-6">
        <img src="{!!url('front/images/goods-list2.png')!!}" class="img-thumbnail">

        </div>
        <div class="col-md-6">
            <p>商品列表页可以轻松切换商品缩略图</p>
            <p>可以直接加入商品到购物车</p>
        </div>

        </div><!--/row-->

        <div class="btn-tit">【4】商品列表页 ajax筛选 包括：ajax排序 ajax分页 ajax属性筛选</div>
        <div class="row">
        <div class="col-md-6">
        <img src="{!!url('front/images/goods-list.png')!!}" class="img-thumbnail">
       </div>
       <div class="col-md-6">
          <p>列表页 ajax属性筛选 动态刷新效果</p>
          <p>列表页 ajax排序 动态刷新效果</p>
          <p>列表页 ajax分页 动态刷新效果</p>
          <p>列表页 ajax价格筛选 动态刷新效果</p>
      </div>
       </div>

       <div class="btn-tit">【5】商品属性链库存 动态刷新货品编号和库存</div>
       <div class="row">
       <div class="col-md-6">
       <img src="{!!url('front/images/goods-attr.png')!!}" class="img-thumbnail">
      </div>
      <div class="col-md-6">
         <p>可以为不同的颜色 添加不同的颜色值和颜色商品图片</p>
         <p>可以添加属性链组合的货号和库存</p>
         <p>点选不同的属性组合 会ajax切换属性链货品的编号和库存</p>
         <p>商品内置放大镜效果</p>
     </div>
      </div>

      <div class="btn-tit">【6】包含商品添加到购物车和直接购买功能</div>
      <div class="row">
      <div class="col-md-6">
      <img src="{!!url('front/images/cart.png')!!}" class="img-thumbnail">
     </div>
     <div class="col-md-6">
        <p>商品ajax添加到购物车功能</p>
       <p>商品可以直接ajax购买</p>
    </div>
     </div>

     <div class="btn-tit">【7】原生优雅的目录似链接并可轻松自定义链接 利于seo</div>

     <div class="row">
     <div class="col-md-6">
     <img src="{!!url('front/images/diy.png')!!}" class="img-thumbnail">
    </div>
    <div class="col-md-6">
       <p>系统的链接默认为目录似 默认如下:</p>
      <p>首页:/</p>
      <p>商品列表页:category/{id}</p>
      <p>商品详情页:goods/{id}</p>
      <p>购物车页面:cart</p>
      <p>结算页面:checkout</p>
      <p>用户中心:auth/center</p>
      <p>登录页面:auth/login</p>
      <p>注册页面:auth/register</p>
      <p>以上所有页面 都可以轻松自定义为任何形式</p>
      <p>PHPStore的路由系统可以方便轻松自定义</p>
   </div>
    </div>

        <div class="btn-tit">[8]PHPStore底层框架为Laravel 也是全网首款基于Laravel框架的商城系统。我们和ecshop没任何关系</div>
          <div class="row">
             <div class="col-md-3">
               <img src="{!!url('front/images/psb4.jpg')!!}" class="img-thumbnail">
               <p>PHPStore官方Twitter</p>
            </div>
            <div class="col-md-3">
              <img src="{!!url('front/images/psb5.jpg')!!}" class="img-thumbnail">
              <p>PHPStore和Taylor Twell互动</p>
           </div>
             <div class="col-md-3">
               <img src="{!!url('front/images/psb2.jpg')!!}" class="img-thumbnail">
               <p>给迷惑的用户答疑</p>
            </div>
            <div class="col-md-3">
              <img src="{!!url('front/images/psb3.jpg')!!}" class="img-thumbnail">
              <p>Laravel框架创始人:Taylor Twell</p>
           </div>
         </div><!--row-->




    </div><!--/middle-->

</body>
</html>
