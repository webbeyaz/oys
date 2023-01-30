<!DOCTYPE html>
<html lang="tr" class="loading" data-textdirection="ltr">

<!-- BEGIN: Head-->
<head>

	@include('client.layouts.partials.tags')

	<title>@yield('title', 'Ofis Yönetim Sistemi')</title>
	<meta name="robots" content="noindex, nofollow">

	@include('client.layouts.partials.icons')

	<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

	@include('admin.layouts.partials.styles')

	@yield('styles')

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->
<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="">

	@include('admin.layouts.partials.header')

	@include('admin.layouts.partials.main-menu')

	<!-- BEGIN: Content-->
	<div class="app-content content ">
		<div class="content-overlay"></div>
		<div class="header-navbar-shadow"></div>
		<div class="content-wrapper container-xxl p-0">
			<div class="content-header row">
			</div>
			<div class="content-body">

				@yield('content')

			</div>
		</div>
	</div>
	<!-- END: Content-->

	<div class="sidenav-overlay"></div>
	<div class="drag-target"></div>

	@include('admin.layouts.partials.footer')

	@include('admin.layouts.partials.scripts')

	@yield('scripts')

</body>
<!-- END: Body-->

</html>
