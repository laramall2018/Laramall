<!DOCTYPE html>
  <html>
    <head>
      <!--Import Google Icon Font-->

      <style type="text/css">
        @font-face {
            font-family: 'Material Icons';
            font-style: normal;
            font-weight: 400;
              src: url({!!$google_font_url!!}/front/materialize/iconfont/MaterialIcons-Regular.eot); /* For IE6-8 */
              src: local('Material Icons'),
                   local('MaterialIcons-Regular'),
                   url({!!$google_font_url!!}/front/materialize/iconfont/MaterialIcons-Regular.woff2) format('woff2'),
                   url({!!$google_font_url!!}/front/materialize/iconfont/MaterialIcons-Regular.woff) format('woff'),
                   url({!!$google_font_url!!}/front/materialize/iconfont/MaterialIcons-Regular.ttf) format('truetype');
        }
        .material-icons {
          font-family: 'Material Icons';
          font-weight: normal;
          font-style: normal;
          font-size: 24px;  /* Preferred icon size */
          display: inline-block;
          width: 1em;
          height: 1em;
          line-height: 1;
          text-transform: none;
          letter-spacing: normal;
          word-wrap: normal;
          white-space: nowrap;
          direction: ltr;

          /* Support for all WebKit browsers. */
          -webkit-font-smoothing: antialiased;
          /* Support for Safari and Chrome. */
          text-rendering: optimizeLegibility;

          /* Support for Firefox. */
          -moz-osx-font-smoothing: grayscale;

          /* Support for IE. */
          font-feature-settings: 'liga';
        }
      </style>
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="{!!url('front/materialize/css/materialize.min.css')!!}"  media="screen,projection"/>
      <link type="text/css" rel="stylesheet" href="{!!url('front/materialize/font-awesome/css/font-awesome.min.css')!!}"/>
      <link type="text/css" rel="stylesheet" href="{!!url('front/materialize/css/style.css')!!}"/>
      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
      <!--Import jQuery before materialize.js-->
      <script type="text/javascript" src="{!!url('front/materialize/js/jquery.min.js')!!}"></script>
      <script type="text/javascript" src="{!!url('front/materialize/js/materialize.min.js')!!}"></script>
    </head>
    <body id="demo-body">

      <!-- row -->

      <div class="row">
        <div class="col s12">
          <div class="card blue-grey darken-1">
            <div class="card-image">
              <img src="{!!url('front/materialize/images/home.png')!!}">
            </div>
            <div class="card-content white-text">
              <p>查看演示站请输入查看密码！</p>
              <p>密码可以向管理员索取</p>
              <p>QQ/微信号:179536444</p>
            </div>
          </div>
        </div>
      </div>
  
      <!--row end-->
      @if(Auth::check('demo'))
         <div class="container">
        <div class="row">
          <a href="{!!url('/')!!}" class="btn btn-red">查看演示</a>
          <a href="{!!url('demo/logout')!!}" class="btn blue">退出演示</a>
        </div>
        </div>
      @else
      @include('demo.form')
      @endif

    </body>
  </html>
