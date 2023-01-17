<!-- BEGIN: Vendor JS -->
<script src="{{ asset_url('app/vendors/js/vendors.min.js') }}"></script>
<!-- BEGIN Vendor JS -->

<!-- BEGIN: Page Vendor JS -->
<script src="{{ asset_url('app/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS -->
<script src="{{ asset_url('app/js/core/app-menu.js') }}"></script>
<script src="{{ asset_url('app/js/core/app.js') }}"></script>
<!-- END: Theme JS -->

<!-- BEGIN: Page JS -->
<script src="{{ asset_url('app/js/scripts/pages/auth-login.js') }}"></script>
<!-- END: Page JS -->

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
