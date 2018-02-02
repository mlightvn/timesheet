
<!-- ========================== Footer ========================== -->
		</div>
	</div>
<br>


@if (isset($datetimepicker) && ($datetimepicker == true))
<script src="/js/common/jquery.datetimepicker.full.min.js"></script>
@endif

<script src="/js/common/rakuhin.js"></script>

@if (isset($js_list))
<script src="/js/common/list.js"></script>
@endif

@if (isset($js))
<script src="/js/{{ $js }}.js"></script>
@endif

<script src="/js/alert.box.js"></script>

<div class="w3-border w3-border-black"></div>
<footer class="w3-container w3-gray">
	<a href="/timesheet/" class="w3-text-white w3-hover-text-red">{{ env("APP_NAME") }}</a>
</footer>
</div>
</body>
</html>
