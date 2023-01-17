<!DOCTYPE html>
<html lang="en">
<head>

	<!-- Required meta tags  -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">

	<title>@yield('title', 'Panel :: HaxMonster')</title>
	<meta name="description" content="@yield('description', 'Description.')">

	<meta name="robots" content="noindex, nofollow">

	<link rel="icon" type="image/png" href="{{ asset_url('panel/img/favicon.png') }}">

	<!--Core CSS -->
	<link rel="stylesheet" href="{{ asset_url('panel/css/app.css') }}">
	<link rel="stylesheet" href="{{ asset_url('panel/css/main.css') }}">
	<link rel="stylesheet" href="{{ asset_url('panel/css/custom.css') }}">

	<!-- Fonts -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800;900&display=swap">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,700">

	@yield('styles')

	<script>
		const API_URL = '{{ site_url('api') }}'
	</script>
</head>
<body>
	<div class="app-wrapper" id="huro-app">

		<!-- Page loader -->
		<div class="pageloader is-full"></div>
		<div class="infraloader is-full is-active"></div>

		<div class="auth-wrapper">

			@yield('content')

		</div>
	</div>

	<!-- Concatenated plugins -->
	<script src="{{ asset_url('panel/js/app.js') }}"></script>

	<!-- Huro js -->
	<script src="{{ asset_url('panel/js/functions.js') }}"></script>
	<script src="{{ asset_url('panel/js/auth.js') }}"></script>
	<script src="{{ asset_url('panel/js/custom.js') }}"></script>

	@yield('scripts')
</body>
</html>
