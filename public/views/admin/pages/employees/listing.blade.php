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
		<div class="content-header-left col-12 mb-2">
			<div class="row breadcrumbs-top">
				<div class="col-12">
					<h2 class="content-header-title float-start mb-0">
						Personel Listesi
					</h2>
					<div class="breadcrumb-wrapper">
						<ol class="breadcrumb">
							<li class="breadcrumb-item">
								<a href="{{ site_url('admin/dashboard') }}">
									Anasayfa
								</a>
							</li>
							<li class="breadcrumb-item">
								Personeller
							</li>
							<li class="breadcrumb-item active">
								Personel Listesi
							</li>
						</ol>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="content-body">

		@if ($employees)

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
										<!--<th>
											Durum
										</th>-->
										<th>
											Oluşturulma Tarihi
										</th>
										<th>
											İşlem
										</th>
									</tr>
								</thead>
								<tbody>

									@foreach ($employees as $employee)

										<tr>
											<td>
												<img src="{{ $employee->photo ? upload_url('images/cache/employees/20x20/' . $employee->photo) : asset_url('app/images/avatars/default.jpg') }}" alt="{{ $employee->username }}" width="20" height="20" class="me-75 avatar">
												<span class="fw-bold">{{ $employee->username }}</span>
											</td>
											<td>
												{{ $employee->firstname . ' ' . $employee->lastname }}
											</td>
											<!--<td>
												<span class="badge rounded-pill badge-light-{{ $employee->status == 1 ? 'success' : 'danger' }} me-1">
													{{ $employee->status == 1 ? 'Aktif' : 'Pasif' }}
												</span>
											</td>-->
											<td>
												{{ timeConvert($employee->created_at, 'd F Y H:i') }}
											</td>
											<td>
												<div class="dropdown">
													<button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0" data-bs-toggle="dropdown">
														<i data-feather="more-vertical"></i>
													</button>
													<div class="dropdown-menu dropdown-menu-end">
														<a href="{{ site_url('admin/employees/edit/' . $employee->id) }}" class="dropdown-item">
															<i data-feather="edit-2" class="me-50"></i>
															<span>Düzenle</span>
														</a>
														<a href="{{ site_url('admin/employees/delete/' . $employee->id) }}" class="dropdown-item">
															<i data-feather="trash" class="me-50"></i>
															<span>Sil</span>
														</a>
													</div>
												</div>
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
							Sistemde kayıtlı personel bulunamadı.
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
@endsection

@section('scripts')

	<script type="text/javascript">
		$(function () {
			$('.datatables-basic').DataTable({
				language: {
					url: '//cdn.datatables.net/plug-ins/1.13.1/i18n/tr.json'
				},
				order: [[2, 'desc']],
				columnDefs: [{
					targets: 2,
					render: DataTable.render.datetime('D MMM YYYY H:i'),
				}]
			});
		});
	</script>

@endsection
