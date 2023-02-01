@extends('admin.layouts.default')

@section('title', 'Ofis Yönetim Sistemi')

@section('styles_vendor')

@endsection

@section('styles_page')

@endsection

@section('styles')
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

		<!-- Basic Tables start -->
		<div class="row" id="basic-table">
			<div class="col-12">
				<div class="card">
					<div class="card-header border-bottom p-1">
						<div class="card-title">
							Personeller
						</div>
						<div class="text-end">
							<div class="d-inline-flex">
								<div class="btn-group">
									<button class="btn btn-outline-secondary dropdown-toggle" type="button" id="exportMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
										<span>
											<i data-feather="share" class="font-small-4 me-50"></i>
											Dışarı Aktar
										</span>
									</button>
									<div class="dropdown-menu" aria-labelledby="exportMenuButton">
										<a href="#" class="dropdown-item">
											<span>
												<i data-feather="printer" class="font-small-4 me-50"></i>
											</span>
											Yazdır
										</a>
										<a href="#" class="dropdown-item">
											<span>
												<i data-feather="file-text" class="font-small-4 me-50"></i>
											</span>
											CSV
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="card-body">
						<p class="card-text">
							Bu sayfa içerisinden personelleri özellikleriyle beraber görüntüleyebilirsiniz.
						</p>
					</div>
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
		</div>
		<!-- Basic Tables end -->

	</div>

@endsection

@section('scripts_vendor')

@endsection

@section('scripts_page')

@endsection

@section('scripts')
@endsection
