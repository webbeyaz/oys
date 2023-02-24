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
				<div class="col-8">
					<h2 class="content-header-title float-start mb-0">
						Araç Takibi
					</h2>
					<div class="breadcrumb-wrapper">
						<ol class="breadcrumb">
							<li class="breadcrumb-item">
								<a href="{{ site_url('admin/dashboard') }}">
									Anasayfa
								</a>
							</li>
							<li class="breadcrumb-item">
								<a href="{{ site_url('admin/vehicles/list') }}">
									Araçlar
								</a>
							</li>
							<li class="breadcrumb-item active">
								Araç Takibi
							</li>
						</ol>
					</div>
				</div>
			</div>
		</div>
		<div class="content-header-right col-md-3 col-12 mb-2 d-flex justify-content-end">
			<a href="{{ site_url('admin/vehicles/tracking/add') }}" class="btn btn-primary">
				<i data-feather="plus-circle"></i>
				<span>Kayıt Ekle</span>
			</a>
		</div>
	</div>
	<div class="content-body">

		@if ($events)

			<!-- Basic table -->
			<section id="basic-datatable">
				<div class="row">
					<div class="col-12">
						<div class="card">
							<table class="datatables-basic table">
								<thead>
									<tr>
										<th>
											Araç Plakası
										</th>
										<th>
											Açıklama
										</th>
										<th>
											Resim(ler)
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

									@foreach ($events as $event)

										<tr>
											<td>
												{{ $event['plate'] }}
											</td>
											<td>
												{{ $event['text'] }}
											</td>
											<td>

												@if ($event['images'])

													<div class="avatar-group">

														@php
															$i = 0;
														@endphp

														@foreach ($event['images'] as $image)

															@if ($i < 4)

																<div class="avatar pull-up" data-popup="tooltip-custom">
																	<img src="{{ upload_url('images/cache/events/40x40/' . $image->image) }}" alt="{{ $image->id }}" width="40" height="40" data-bs-toggle="modal" data-bs-target="#imageModal{{ $image->id }}">
																</div>
																<div class="modal fade" id="imageModal{{ $image->id }}" tabindex="-1" aria-labelledby="{{ $image->image }}" aria-hidden="true">
																	<div class="modal-dialog modal-dialog-centered">
																		<div class="modal-content">
																			<div class="modal-header">
																				<h5 class="modal-title" id="exampleModalCenterTitle">
																					Resim
																				</h5>
																				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
																			</div>
																			<div class="modal-body">
																				<img src="{{ upload_url('images/cache/events/400x400/' . $image->image) }}" alt="{{ $image->id }}">
																			</div>
																			<div class="modal-footer">
																				<a href="{{ upload_url('images/original/events/' . $image->image) }}" download class="btn btn-primary">
																					İndir
																				</a>
																				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
																					Kapat
																				</button>
																			</div>
																		</div>
																	</div>
																</div>

															@endif

															@php
																$i++;
															@endphp

														@endforeach

														@if ($event['images']->rowCount() > 4)

															<h6 class="align-self-center cursor-pointer ms-50 mb-0">
																+{{ $event['images']->rowCount() - 4 }}
															</h6>

														@endif

													</div>

												@else

													Resim yüklenmemiş.

												@endif

											</td>
											<td>
												{{ timeConvert($event['created_at'], 'd F Y H:i') }}
											</td>
											<td>
												<div class="dropdown">
													<button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0" data-bs-toggle="dropdown">
														<i data-feather="more-vertical"></i>
													</button>
													<div class="dropdown-menu dropdown-menu-end">
														<a href="{{ site_url('admin/vehicles/tracking/edit/' . $event['id']) }}" class="dropdown-item">
															<i data-feather="edit-2" class="me-50"></i>
															<span>Düzenle</span>
														</a>
														<a href="{{ site_url('admin/vehicles/tracking/delete/' . $event['id']) }}" class="dropdown-item">
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
							Sistemde kayıt bulunamadı.
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
				order: [[3, 'desc']]
			});
		});
	</script>

@endsection
