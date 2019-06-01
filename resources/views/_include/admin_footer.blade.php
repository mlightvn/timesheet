
<!-- ========================== Footer ========================== -->
		</div>
	</div>
<br>

@if (isset($datetimepicker) && ($datetimepicker == true))
<script src="/js/common/jquery.datetimepicker.full.min.js"></script>
@endif

@if (isset($daterangepicker) && ($daterangepicker == true))
<script src="/js/common/moment.min.js"></script>
<script src="/js/common/daterangepicker.js"></script>
@endif

@if (isset($datepicker) && ($datepicker == true))
<script src="/js/common/jquery-ui.js"></script>
@endif

<script src="/js/common/rakuhin.js"></script>

@if (isset($js_list))
<script src="/js/common/list.js"></script>
@endif

@if (isset($js_listing))
<script src="/js/common/listing.js"></script>
@endif

@if (isset($js))
<script src="/js/{{ $js }}.js"></script>
@endif

<script type="text/javascript">
$(function() {
	$("img.lazy").lazyload({
		effect : "fadeIn"
	});
});
</script>

<script src="/js/alert.box.js"></script>

<div class="w3-border w3-border-black"></div>
<footer class="w3-container w3-gray">
	<a href="/" class="w3-text-white w3-hover-text-red">{{ __("message.APP_NAME") }}</a>
	&nbsp;|&nbsp;
	<a href="https://coxanh.coupon-pon.net/about" target="_blank" class="w3-text-white w3-hover-text-red">About me</a>
</footer>
</div>

{{--
@if(date('Y/m/d H:i:s') <= '2018/09/31 23:59:59')
<div class="fireworks">
	<aside id="library">
		<img src="/plugins/fireworks/big-glow.png" id="big-glow" />
		<img src="/plugins/fireworks/small-glow.png" id="small-glow" />
	</aside>

</div>

<script>
window.requestAnimFrame = (function(){
  return  window.requestAnimationFrame       ||
          window.webkitRequestAnimationFrame ||
          window.mozRequestAnimationFrame    ||
          window.oRequestAnimationFrame      ||
          window.msRequestAnimationFrame     ||
          function( callback ){
            window.setTimeout(callback, 1000 / 60);
          };
})();
</script>
<script src="/js/plugins/fireworks.js"></script>

@elseif(date('Y/m/d H:i:s') <= '2019/02/28 23:59:59')
<div class="snow">
	<canvas id="canvas"></canvas>

</div>
<script src="/js/plugins/snow.js"></script>

@endif
--}}

</body>
</html>
