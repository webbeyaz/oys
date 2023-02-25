@extends('admin.layouts.default')

@section('title', 'Ofis Yönetim Sistemi')

@section('styles_vendor')
	<link rel="stylesheet" type="text/css" href="{{ asset_url('app/vendors/css/tables/datatable/dataTables.bootstrap5.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset_url('app/vendors/css/tables/datatable/responsive.bootstrap5.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset_url('app/vendors/css/tables/datatable/buttons.bootstrap5.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset_url('app/vendors/css/tables/datatable/rowGroup.bootstrap5.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset_url('app/vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
@endsection

@section('styles_page')
	<link rel="stylesheet" type="text/css" href="{{ asset_url('app/css/core/menu/menu-types/vertical-menu.css') }}">
@endsection

@section('styles')
	<style type="text/css">
		.dataTables_wrapper .row:first-child,
		.dataTables_wrapper .row:last-child {
			margin: 0 auto;
		}
	</style>
@endsection

@section('content')

	<div class="content-header row">
		<div class="content-header-left col-md-9 col-12 mb-2">
			<div class="row breadcrumbs-top">
				<div class="col-12">
					<h2 class="content-header-title float-start mb-0">
						Kayıtlar
					</h2>
					<div class="breadcrumb-wrapper">
						<ol class="breadcrumb">
							<li class="breadcrumb-item">
								<a href="{{ site_url('admin/dashboard') }}">
									Anasayfa
								</a>
							</li>
							<li class="breadcrumb-item active">
								Kayıtlar
							</li>
						</ol>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="content-body">

		@if ($logs)

			<!-- Basic table -->
			<section id="basic-datatable">
				<div class="row">
					<div class="col-12">
						<div class="card">
							<table class="datatables-basic table">
								<thead>
								<tr>
									<th>
										Kayıt
									</th>
									<th>
										Tarih
									</th>
								</tr>
								</thead>
								<tbody>

								@foreach ($logs as $log)

									<tr>
										<td>
											{!! $log->text !!}
										</td>
										<td>
											{{ timeConvert($log->date, 'd F Y H:i') }}
										</td>
									</tr>

								@endforeach

								</tbody>
							</table>
						</div>
					</div>
				</div>
			</section>
			<!--/ Basic table -->

		@else

			<div class="row">
				<div class="col-12">
					<div class="alert alert-info" role="alert">
						<div class="alert-body">
							Sistemde kayıtlı veri bulunamadı.
						</div>
					</div>
				</div>
			</div>

		@endif

	</div>

@endsection

@section('scripts_vendor')
	<script src="{{ asset_url('app/vendors/js/tables/datatable/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset_url('app/vendors/js/tables/datatable/dataTables.bootstrap5.min.js') }}"></script>
	<script src="{{ asset_url('app/vendors/js/tables/datatable/dataTables.responsive.min.js') }}"></script>
	<script src="{{ asset_url('app/vendors/js/tables/datatable/responsive.bootstrap5.min.js') }}"></script>
	<script src="{{ asset_url('app/vendors/js/tables/datatable/datatables.checkboxes.min.js') }}"></script>
	<script src="{{ asset_url('app/vendors/js/tables/datatable/datatables.buttons.min.js') }}"></script>
	<script src="{{ asset_url('app/vendors/js/tables/datatable/jszip.min.js') }}"></script>
	<script src="{{ asset_url('app/vendors/js/tables/datatable/pdfmake.min.js') }}"></script>
	<script src="{{ asset_url('app/vendors/js/tables/datatable/vfs_fonts.js') }}"></script>
	<script src="{{ asset_url('app/vendors/js/tables/datatable/buttons.html5.min.js') }}"></script>
	<script src="{{ asset_url('app/vendors/js/tables/datatable/buttons.print.min.js') }}"></script>
	<script src="{{ asset_url('app/vendors/js/tables/datatable/dataTables.rowGroup.min.js') }}"></script>
	<script src="{{ asset_url('app/vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>
@endsection

@section('scripts_page')
	<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/locale/tr.js"></script>
	<script src="//cdn.datatables.net/plug-ins/1.13.2/sorting/datetime-moment.js"></script>
@endsection

@section('scripts')

	<script type="text/javascript">
		$(function () {
			moment.locale('tr');
			$.fn.dataTable.moment('DD MMMM YYYY HH:mm');

			$('.datatables-basic').DataTable({
				language: {
					url: '//cdn.datatables.net/plug-ins/1.13.1/i18n/tr.json'
				},
				order: [[1, 'desc']]
			});
		});
	</script>

@endsection
