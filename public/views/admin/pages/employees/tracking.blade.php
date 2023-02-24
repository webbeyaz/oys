@extends('admin.layouts.default')

@section('title', 'Ofis Yönetim Sistemi')

@section('styles_vendor')
	<link rel="stylesheet" type="text/css" href="{{ asset_url('app/vendors/css/tables/datatable/dataTables.bootstrap5.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset_url('app/vendors/css/tables/datatable/responsive.bootstrap5.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset_url('app/vendors/css/tables/datatable/buttons.bootstrap5.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset_url('app/vendors/css/tables/datatable/rowGroup.bootstrap5.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset_url('app/vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset_url('app/vendors/css/forms/select/select2.min.css') }}">
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
		<div class="content-header-left col-md-3 col-12 mb-2">
			<div class="row breadcrumbs-top">
				<div class="col-12">
					<h2 class="content-header-title float-start mb-0">
						Personel Takibi
					</h2>
				</div>
			</div>
		</div>
		<div class="content-header-right col-md-9 col-12 mb-2">
			<div class="breadcrumb-right">
				<form action="{{ site_url('admin/employees/tracking/report') }}" method="post">
					<div class="row m-0">
						<div class="col-3 p-0">
							<input type="text" placeholder="Başlangıç tarihi" class="form-control flatpickr-basic">
						</div>
						<div class="col-3 p-0">
							<input type="text" placeholder="Bitiş tarihi" class="form-control flatpickr-basic">
						</div>
						<div class="col-3 p-0">
							<select name="employee" class="select2 form-select" id="report-select">
								<option value="" selected disabled>
									Personel Seçiniz
								</option>

								@foreach ($employees as $employee)

									<option value="{{ $employee->id }}">
										{{ $employee->firstname . ' ' . $employee->lastname }}
									</option>

								@endforeach

							</select>
						</div>
						<div class="col-3 p-0">
							<button type="submit" disabled class="btn btn-primary btn-round" id="report-button">
								Aylık Rapor
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="content-body">

		@if ($tracking)

			<!-- Basic table -->
			<section id="basic-datatable">
				<div class="row">
					<div class="col-12">
						<div class="card">
							<table class="datatables-basic table">
								<thead>
									<tr>
										<th>
											Personel
										</th>
										<th>
											Ad Soyad
										</th>
										<th>
											Giriş Saati
										</th>
										<th>
											Çıkış Saati
										</th>
										<th>
											Çalışma Süresi
										</th>
										<th>
											Tarih
										</th>
									</tr>
								</thead>
								<tbody>

									@foreach ($tracking as $employee)

										<tr>
											<td>
												<img src="{{ asset_url('app/images/avatars/default.jpg') }}" alt="{{ $employee->username }}" width="20" height="20" class="me-75 avatar">
												<span class="fw-bold">{{ $employee->username }}</span>
											</td>
											<td>
												{{ $employee->firstname . ' ' . $employee->lastname }}
											</td>
											<td>
												{{ timeConvert($employee->start_time, 'H:i') }}
												({{ getDevice($employee->agent_start) }})
											</td>
											<td>
												{{ $employee->end_time ? timeConvert($employee->end_time, 'H:i') : '-' }}
												{{ $employee->agent_end ? '(' . getDevice($employee->agent_end) . ')' : '-' }}
											</td>
											<td>
												@if ($employee->end_time)
													{{ timeDiffHours($employee->start_time, $employee->end_time) }} saat
													(30 dakika mola)
												@else
													-
												@endif
											</td>
											<td>
												{{ timeConvert($employee->start_time, 'd.m.Y') }}
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
							Sistemde kayıtlı giriş ve çıkış bulunamadı.
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
	<script src="{{ asset_url('app/vendors/js/pickers/flatpickr/tr.js') }}"></script>
	<script src="{{ asset_url('app/vendors/js/forms/select/select2.full.min.js') }}"></script>
@endsection

@section('scripts_page')
	<script src="{{ asset_url('app/js/scripts/forms/form-select2.js') }}"></script>
@endsection

@section('scripts')

	<script type="text/javascript">
		$(function () {
			$('.datatables-basic').DataTable({
				language: {
					url: '//cdn.datatables.net/plug-ins/1.13.1/i18n/tr.json'
				},
				order: [[5, 'desc'], [2, 'desc'], [3, 'desc']]
			});

			$('.flatpickr-basic').flatpickr({
				'locale': 'tr'
			});

			$('#report-select').change(function () {
				$('#report-button').prop('disabled', false);
			});
		});
	</script>

@endsection
