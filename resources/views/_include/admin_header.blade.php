<!DOCTYPE html>
<html lang="ja">
<head>
	<title>{{(!empty($title)) ? ($title . " | ") : ""}}{{ __("message.APP_NAME") }}</title>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<meta name="description" content="{{ (!empty($description) ? strip_tags($description) : env('APP_DESCRIPTION')) }}">
	<meta name="keywords" content="{{ (!empty($keyword) ? $keyword : env('APP_KEYWORDS')) }}">

	<link rel="stylesheet" href="/css/common/w3.css">
	<link rel="stylesheet" href="/css/common/fontawesome-all.min.css">
	<link rel="stylesheet" href="/css/common/bootstrap.min.css">

	<link rel="stylesheet" href="/css/common/rakuhin.checkbox.css">
	<link rel="stylesheet" href="/css/common/rakuhin.css">
	<link rel="stylesheet" href="/css/common/custom.styles.css">

	<script src="/js/common/jquery.min.js"></script>
	<script src="/js/common/bootstrap.min.js"></script>
	<script src="/js/common/angular.min.js"></script>

	<link rel="stylesheet" href="/css/alert.box.css">

	@if (isset($datetimepicker) && ($datetimepicker == true))
	<link rel="stylesheet" href="/css/common/jquery.datetimepicker.min.css">
	@endif

	@if (isset($daterangepicker) && ($daterangepicker == true))
	<link rel="stylesheet" href="/css/common/daterangepicker.css">
	@endif

	@if (isset($datepicker) && ($datepicker == true))
	<link rel="stylesheet" href="/css/common/jquery-ui.css">
	@endif

	@if (isset($css))
	<link rel="stylesheet" href="/css/{{ $css }}.css">
	@endif

{{--
	@if(date('Y/m/d H:i:s') <= '2018/09/31 23:59:59')
	<link rel="stylesheet" href="/css/plugins/fireworks.css">
	@elseif(date('Y/m/d H:i:s') <= '2019/02/28 23:59:59')
	<link rel="stylesheet" href="/css/plugins/snow.css">
	@endif
--}}

@if(env('APP_ENV') == 'production')
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-84660939-6"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-84660939-6');
</script>

<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-NBDVN44');</script>
<!-- End Google Tag Manager -->

@endif

</head>

<body>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NBDVN44"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<div class="w3-container">
	<div class="w3-row">
		<div class="w3-col s12 m12 l12">
			@include('_include.admin_menu_top', [
				'id'				=> (isset($id) ? $id : "home"),
			])
		</div>
		<div class="w3-col s12 m12 l12">

<!-- ========================== Header ========================== -->
