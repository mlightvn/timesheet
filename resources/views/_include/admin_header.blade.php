<!DOCTYPE html>
<html lang="ja">
<head>
	<title>{{(!empty($title)) ? ($title . " | ") : ""}}{{ env("APP_NAME") }}</title>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<meta name="description" content="{{ (!empty($description) ? strip_tags($description) : env('APP_DESCRIPTION')) }}">
	<meta name="keywords" content="{{ (!empty($keyword) ? $keyword : env('APP_KEYWORDS')) }}">

	<link rel="stylesheet" href="/css/common/w3.css">
	<link rel="stylesheet" href="/css/common/font-awesome.min.css">
	<link rel="stylesheet" href="/css/common/bootstrap.min.css">

	<link rel="stylesheet" href="/css/admin/checkbox.css">
	<link rel="stylesheet" href="/css/common/rakuhin.css">
	<link rel="stylesheet" href="/css/common/custom.styles.css">

	<script src="/js/common/jquery.min.js"></script>
	<script src="/js/common/bootstrap.min.js"></script>

	<link rel="stylesheet" href="/css/alert.box.css">

	@if (in_array($id, array("time", "day", "task", "holiday")))
	<link rel="stylesheet" href="/css/common/jquery-ui.css">
	<script src="/js/common/jquery-ui.js"></script>
	@endif

	@if (isset($css))
	<link rel="stylesheet" href="/css/{{ $css }}.css">
	@endif

</head>

<body>
<div class="w3-container">
	<div class="w3-row">
		<div class="w3-col s12 m12 l12">
			@include('_include.admin_menu_top', [
				'id'				=> (isset($id) ? $id : "home"),
			])
		</div>
		<div class="w3-col s12 m12 l12">

<!-- ========================== Header ========================== -->
