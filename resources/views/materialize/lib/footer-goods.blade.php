<footer class="page-footer" style="background:#baad7c">
          <div class="container" style="display:none">
            <div class="row">
              <div class="col l6 s12">
                <h5 class="white-text">{!!$shop_name!!}</h5>
                <p class="grey-text text-lighten-4">
                  {!!$footer_desc!!}
                </p>
              </div>
              <div class="col l4 offset-l2 s12">
                <h5 class="white-text">{!!trans('front.help_center')!!}</h5>
                <ul>
                  @if($help)
              		@foreach($help[0]->article as $item)
              		<li>
              				<a href="{!!$item->url()!!}" class="grey-text text-lighten-3">
              					{!!$item->title!!}
              				</a>
              		</li>
                  @endforeach
                  @endif
                </ul>
              </div>
            </div>
          </div>
          <div class="footer-copyright">
            <div class="container">
            © <strong class="red-text">{!!$mobile_version!!}</strong> {!!$icp!!}
            </div>
          </div>
</footer>
<div id="footer-item-goods">
  @include('materialize.lib.button-goods')
</div>
