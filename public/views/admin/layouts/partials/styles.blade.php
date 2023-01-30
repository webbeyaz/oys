<!-- BEGIN: Vendor CSS-->
<link rel="stylesheet" type="text/css" href="{{ asset_url('app/vendors/css/vendors.min.css') }}">

@yield('styles_vendor')

<!-- END: Vendor CSS-->

<!-- BEGIN: Theme CSS-->
<link rel="stylesheet" type="text/css" href="{{ asset_url('app/css/bootstrap.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset_url('app/css/bootstrap-extended.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset_url('app/css/colors.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset_url('app/css/components.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset_url('app/css/themes/dark-layout.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset_url('app/css/themes/bordered-layout.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset_url('app/css/themes/semi-dark-layout.css') }}">

@yield('styles_page')

<!-- BEGIN: Custom CSS-->
<link rel="stylesheet" type="text/css" href="{{ asset_url('css/style.css') }}">
<!-- END: Custom CSS-->
