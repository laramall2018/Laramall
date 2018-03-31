<nav style="background:{{App\Models\StyleModel::wap()}};" name="top">
    <div class="nav-wrapper">
      <a href="{!!url()!!}" class="brand-logo">
        @if($wap_logo)
        <img src="{!!url($wap_logo)!!}" alt="{!!$shop_title!!}" style="width:120px;">
        @else
        PHPStore
        @endif
      </a>
      <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>

      <ul class="side-nav grey lighten-5" id="mobile-demo">
        @if(Auth::check('user'))
        @include('materialize.lib.menu')
        @else
        <li>
            <a href="{!!url('catalog')!!}">
              <i class="small material-icons left">format_line_spacing</i>
              {!!trans('front.category')!!}
            </a>
         </li>
        <li>

        <li>
            <a href="{!!url('auth/register')!!}">
              <i class="small material-icons left">person_add</i>
              {!!trans('front.register')!!}
            </a>
         </li>
        <li>
            <a href="{!!url('auth/login')!!}">
            <i class="material-icons left">account_circle</i>
            {!!trans('front.login')!!}</a>
        </li>

        <li>
            <a href="{!!url('help')!!}">
            <i class="material-icons left">apps</i>
            {!!trans('front.help_center')!!}
          </a>
        </li>
        <li>
            <a href="#">
            <i class="material-icons left">local_phone</i>
            {!!$tel!!}
          </a>
        </li>
        @endif
        <li>
          <a href="{!!url('cart')!!}">
            <i class="material-icons left">shopping_cart</i>
            {!!trans('front.cart')!!}
          </a>
        </li>
      </ul>

      <div class="right top-cart">
        
        <a href="{!!url('cart')!!}">
          <i class="material-icons right">shopping_cart</i>
          <span class="badge" id="top-cart-number">{!!App\Models\Cart::number()!!}</span>
        </a>
      </div>
    </div>
  </nav>
 <script type="text/javascript">
  $(function(){

     $(".button-collapse").sideNav();

  })
 </script>
