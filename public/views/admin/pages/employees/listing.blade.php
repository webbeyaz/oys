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
		<!--<div class="content-header-right text-md-end col-md-3 col-12 d-md-block d-none">
			<div class="mb-1 breadcrumb-right">
				tarih filtreleme
			</div>
		</div>-->
	</div>
	<div class="content-body">

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
										Durum
									</th>
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
										<td>
											<span class="badge rounded-pill badge-light-{{ $employee->status == 1 ? 'success' : 'danger' }} me-1">
												{{ $employee->status == 1 ? 'Aktif' : 'Pasif' }}
											</span>
										</td>
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
			<!-- Modal to add new record -->
			<div class="modal modal-slide-in fade" id="modals-slide-in">
				<div class="modal-dialog sidebar-sm">
					<form class="add-new-record modal-content pt-0">
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
						<div class="modal-header mb-1">
							<h5 class="modal-title" id="exampleModalLabel">New Record</h5>
						</div>
						<div class="modal-body flex-grow-1">
							<div class="mb-1">
								<label class="form-label" for="basic-icon-default-fullname">Full Name</label>
								<input type="text" class="form-control dt-full-name" id="basic-icon-default-fullname" placeholder="John Doe" aria-label="John Doe" />
							</div>
							<div class="mb-1">
								<label class="form-label" for="basic-icon-default-post">Post</label>
								<input type="text" id="basic-icon-default-post" class="form-control dt-post" placeholder="Web Developer" aria-label="Web Developer" />
							</div>
							<div class="mb-1">
								<label class="form-label" for="basic-icon-default-email">Email</label>
								<input type="text" id="basic-icon-default-email" class="form-control dt-email" placeholder="john.doe@example.com" aria-label="john.doe@example.com" />
								<small class="form-text"> You can use letters, numbers & periods </small>
							</div>
							<div class="mb-1">
								<label class="form-label" for="basic-icon-default-date">Joining Date</label>
								<input type="text" class="form-control dt-date" id="basic-icon-default-date" placeholder="MM/DD/YYYY" aria-label="MM/DD/YYYY" />
							</div>
							<div class="mb-4">
								<label class="form-label" for="basic-icon-default-salary">Salary</label>
								<input type="text" id="basic-icon-default-salary" class="form-control dt-salary" placeholder="$12000" aria-label="$12000" />
							</div>
							<button type="button" class="btn btn-primary data-submit me-1">Submit</button>
							<button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
						</div>
					</form>
				</div>
			</div>
		</section>
		<!--/ Basic table -->

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
			$('.datatables-basic').DataTable();
		});
	</script>

@endsection
