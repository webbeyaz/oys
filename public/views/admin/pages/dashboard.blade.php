@extends('admin.layouts.default')

@section('title', 'Ofis Yönetim Sistemi')

@section('styles_vendor')
	<link rel="stylesheet" type="text/css" href="{{ asset_url('app/vendors/css/charts/apexcharts.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset_url('app/vendors/css/extensions/toastr.min.css') }}">
@endsection

@section('styles_page')
	<link rel="stylesheet" type="text/css" href="{{ asset_url('app/css/core/menu/menu-types/vertical-menu.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset_url('app/css/pages/dashboard-ecommerce.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset_url('app/css/plugins/charts/chart-apex.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset_url('app/css/plugins/extensions/ext-component-toastr.css') }}">
@endsection

@section('styles')
@endsection

@section('content')

	<div class="content-header row"></div>
	<div class="content-body">

		<!-- Dashboard Ecommerce Starts -->
		<section id="dashboard-ecommerce">
			<div class="row match-height">

				<!-- Medal Card -->
				<!--<div class="col-xl-4 col-md-6 col-12">
					<div class="card card-congratulation-medal">
						<div class="card-body">
							<h5>
								Tebrikler 🎉 Muhammed!
							</h5>
							<p class="card-text font-small-3">
								You have won gold medal
							</p>
							<h3 class="mb-75 mt-2 pt-50">
								<a href="#">$48.9k</a>
							</h3>
							<button type="button" class="btn btn-primary">
								View Sales
							</button>
							<img src="{{ asset_url('app/images/illustration/badge.svg') }}" alt="Madalya"  class="congratulation-medal">
						</div>
					</div>
				</div>-->
				<!--/ Medal Card -->

				<!-- Statistics Card -->
				<div class="col-12">
					<div class="card card-statistics">
						<div class="card-header">
							<h4 class="card-title">
								İstatistikler
							</h4>
							<div class="d-flex align-items-center">
								<p class="card-text font-small-2 me-25 mb-0">
									Az önce güncellendi
								</p>
							</div>
						</div>
						<div class="card-body statistics-body">
							<div class="row">
								<div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
									<div class="d-flex flex-row">
										<div class="avatar bg-light-primary me-2">
											<div class="avatar-content">
												<i data-feather="user" class="avatar-icon"></i>
											</div>
										</div>
										<div class="my-auto">
											<h4 class="fw-bolder mb-0">
												{{ $statistics['employee'] }}
											</h4>
											<p class="card-text font-small-3 mb-0">
												Personel
											</p>
										</div>
									</div>
								</div>
								<div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
									<div class="d-flex flex-row">
										<div class="avatar bg-light-info me-2">
											<div class="avatar-content">
												<i data-feather="anchor" class="avatar-icon"></i>
											</div>
										</div>
										<div class="my-auto">
											<h4 class="fw-bolder mb-0">
												{{ $statistics['driver'] }}
											</h4>
											<p class="card-text font-small-3 mb-0">
												Şoför
											</p>
										</div>
									</div>
								</div>
								<div class="col-xl-3 col-sm-6 col-12 mb-2 mb-sm-0">
									<div class="d-flex flex-row">
										<div class="avatar bg-light-danger me-2">
											<div class="avatar-content">
												<i data-feather="truck" class="avatar-icon"></i>
											</div>
										</div>
										<div class="my-auto">
											<h4 class="fw-bolder mb-0">
												{{ $statistics['vehicle'] }}
											</h4>
											<p class="card-text font-small-3 mb-0">
												Araç
											</p>
										</div>
									</div>
								</div>
								<div class="col-xl-3 col-sm-6 col-12 mb-2 mb-sm-0">
									<div class="d-flex flex-row">
										<div class="avatar bg-light-success me-2">
											<div class="avatar-content">
												<i data-feather="list" class="avatar-icon"></i>
											</div>
										</div>
										<div class="my-auto">
											<h4 class="fw-bolder mb-0">
												{{ $statistics['event'] }}
											</h4>
											<p class="card-text font-small-3 mb-0">
												Araç Kaydı
											</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--/ Statistics Card -->

			</div>

			@if ($tracking)

				<div class="row match-height">

					<!-- Company Table Card -->
					<div class="col-12">
						<div class="card card-company-table">
							<div class="card-body p-0">
								<div class="table-responsive">
									<table class="table">
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
											<tr>

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
														</td>
														<td>
															{{ $employee->end_time ? timeConvert($employee->end_time, 'H:i') : '-' }}
														</td>
														<td>
															@if ($employee->end_time)
																{{ timeDiffHours($employee->start_time, $employee->end_time) }} saat
																({{ timeDiffMinutes($employee->start_time, $employee->end_time) }} dakika)
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
					</div>
					<!--/ Company Table Card -->

				</div>

			@endif

		</section>
		<!-- Dashboard Ecommerce ends -->

	</div>

@endsection

@section('scripts_vendor')
	<script src="{{ asset_url('app/vendors/js/charts/apexcharts.min.js') }}"></script>
	<script src="{{ asset_url('app/vendors/js/extensions/toastr.min.js') }}"></script>
@endsection

@section('scripts_page')
	<script src="{{ asset_url('app/js/scripts/pages/dashboard-ecommerce.js') }}"></script>
@endsection

@section('scripts')
@endsection
