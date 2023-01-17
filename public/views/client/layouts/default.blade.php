<!DOCTYPE html>
<html lang="tr" class="loading" data-textdirection="ltr">

<!-- BEGIN: Head -->
<head>

	@include('client.layouts.partials.tags')

	<title>@yield('title', 'Ofis Yönetim Sistemi')</title>
	<meta name="description" content="@yield('description', 'Açıklama.')">

	<meta name="robots" content="noindex, nofollow">

	@include('client.layouts.partials.icons')

	<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

	@include('client.layouts.partials.styles')

	@yield('styles')

</head>
<!-- END: Head -->

<!-- BEGIN: Body -->
<body class="vertical-layout vertical-menu-modern blank-page navbar-floating footer-static" data-open="click" data-menu="vertical-menu-modern" data-col="blank-page">

	<!-- BEGIN: Content -->
	<div class="app-content content">
		<div class="content-overlay"></div>
		<div class="header-navbar-shadow"></div>
		<div class="content-wrapper">
			<div class="content-header row"></div>
			<div class="content-body">

				@yield('content')

			</div>
		</div>
	</div>
	<!-- END: Content -->

	@include('client.layouts.partials.scripts')

	@yield('scripts')

</body>
<!-- END: Body -->

</html>
