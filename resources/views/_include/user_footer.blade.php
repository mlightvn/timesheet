
<!-- ========================== Footer ========================== -->
		</div>
	</div>
<br>


@if (isset($js))
<script src="/js/{{ $js }}.js"></script>
@endif


<div class="w3-border w3-border-black"></div>
<footer class="w3-container w3-gray">
	<a href="/timesheet/" class="w3-text-white w3-hover-text-red">{{ env("APP_NAME") }}</a>
</footer>
</div>
</body>
</html>
