<!DOCTYPE html>
<html>
    <head>
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
       <!--Import jQuery before materialize.js-->
      <script type="text/javascript" src="{!!url('front/matrix/googlecss/js/jquery.min.js')!!}"></script>
      <script type="text/javascript" src="{!!url('front/matrix/googlecss/materialize/js/materialize.min.js')!!}"></script>
      <script type="text/javascript" src="{!!url('front/matrix/googlecss/js/order.js')!!}"></script>
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="{!!url('front/matrix/googlecss/materialize/css/materialize.min.css')!!}"  media="screen,projection"/>
      <link href="{!!url('front/matrix/googlecss/materialize/css/googlefont.css')!!}" rel="stylesheet">
      <link type="text/css" rel="stylesheet" href="{!!url('front/matrix/googlecss/css/style.css')!!}" />
      <title>{!!trans('front.user_message')!!}</title>
    </head>
    <body>
        
        
  <div class="row">
    
        {!!Form::open(['url'=>'message','method'=>'post','files'=>true,'class'=>'col s12'])!!}
        
      
        <div class="row">
        <div class="input-field col s12">
          
          <input id="username" name="username" type="text" class="validate" length=20>
          <label for="username">用户名称</label>
        </div>
            
        <div class="row">
        <div class="input-field col s12">
         
          <input id="email" name="email" type="email" class="validate">
          <label for="email" data-error="格式错误" data-success="正确">Email</label>
        </div>
       </div><!--/row-->
       
       <div class="row">
        <div class="input-field col s12">
         
          <input id="phone" name="phone" type="text" >
          <label for="phone" >手机号码</label>
        </div>
       </div><!--/row-->
            
       <div class="row">
        <div class="input-field col s12">
         
          <input id="qq" name="qq" type="text" >
          <label for="qq" >QQ号码</label>
        </div>
       </div><!--/row-->
       
       <div class="row">
        <div class="input-field col s12">
         
          <input id="weixin" name="weixin" type="text" >
          <label for="weixin" >微信账号</label>
        </div>
       </div><!--/row-->
       
       <div class="row">
        <div class="input-field col s12">
          
          <input id="domain" name="domain" type="text" >
          <label for="domain" >绑定域名</label>
        </div>
       </div><!--/row-->
       
       
     
      <div class="row">
           
          <div class="input-field col s12">
    <select name="ecsvip_ver" id="ecsvip_ver">
      <option value="" disabled selected>选择授权方式</option>
      <option value="wap版">wap版</option>
      <option value="b2c永久授权">b2c永久授权</option>
      <option value="b2c一站式解决方案">b2c一站式解决方案</option>
    </select>
    
  </div>

     
     </div>
    <div class="row">
        <div class="input-field col s12">
           
          <input id="price" name="price" type="text" value="20000" >
          <label for="price" >价格</label>
        </div>
       </div><!--/row-->
    
    
  <div class="row">
      <div class="input-field col s10 offset-s1">
    <button type="submit" class="waves-effect btn-large red">
    <i class="material-icons left">done</i>
    确认下单
    </button>
      </div>
      
 </div>
      
    

      {!!Form::close()!!}
      
  </div><!--/row--> 
   
</body>
</html>