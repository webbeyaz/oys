<!-- BEGIN: Vendor JS-->
<script src="{{ asset_url('app/vendors/js/vendors.min.js') }}"></script>
<!-- BEGIN Vendor JS-->

@yield('scripts_vendor')

<!-- BEGIN: Theme JS-->
<script src="{{ asset_url('app/js/core/app-menu.js') }}"></script>
<script src="{{ asset_url('app/js/core/app.js') }}"></script>
<!-- END: Theme JS-->

@yield('scripts_page')

<script>
	$(window).on('load', function() {
		if (feather) {
			feather.replace({
				width: 14,
				height: 14
			});
		}
	})
</script>
