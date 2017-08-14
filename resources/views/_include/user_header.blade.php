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

<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<link rel="stylesheet" href="/css/common/custom.styles.css">


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

@if (isset($css))
<link rel="stylesheet" href="/css/{{ $css }}.css">
@endif

</script>
</head>
<body>
<div class="w3-container">
	<div class="w3-row">
		<div class="w3-col s12 m12 l12">
			@include('_include.user_menu_top', [
				'id'				=> (isset($id) ? $id : "home"),
			])
		</div>
		<div class="w3-col s12 m12 l12">

<!-- ========================== Header ========================== -->
