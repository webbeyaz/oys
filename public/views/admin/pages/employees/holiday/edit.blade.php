@extends('admin.layouts.default')

@section('title', 'Ofis Yönetim Sistemi')

@section('styles_vendor')
	<link rel="stylesheet" type="text/css" href="{{ asset_url('app/vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
@endsection

@section('styles_page')
@endsection

@section('styles')
@endsection

@section('content')

	<div class="content-header row">
		<div class="content-header-left col-12 mb-2">
			<div class="row breadcrumbs-top">
				<div class="col-12">
					<h2 class="content-header-title float-start mb-0">
						Personel İzni Düzenle
					</h2>
					<div class="breadcrumb-wrapper">
						<ol class="breadcrumb">
							<li class="breadcrumb-item">
								<a href="{{ site_url('admin/dashboard') }}">
									Anasayfa
								</a>
							</li>
							<li class="breadcrumb-item">
								<a href="{{ site_url('admin/employees/holiday') }}">
									Personel İzinleri
								</a>
							</li>
							<li class="breadcrumb-item active">
								Personel İzni Düzenle
							</li>
						</ol>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="content-body">

		<!-- Basic Inputs start -->
		<section id="basic-input">

			<form action="" method="post">

				<div class="row">
					<div class="col-md-12">

						@if ($message)

							<div class="alert alert-{{ $message['class'] }}" role="alert">
								<div class="alert-body">
									{{ $message['text'] }}
								</div>
							</div>

						@endif

						<div class="card">
							<div class="card-header">
								<h4 class="card-title">
									Personel İzni Düzenle
								</h4>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-12">
										<div class="mb-1">
											<label class="form-label" for="employee_id">
												Personel
											</label>
											<select name="employee_id" class="form-control" id="employee_id">

												@foreach ($employees as $employee)

													<option value="{{ $employee->id }}" {{ $employee->id == $holiday->employee_id ? 'selected' : null }}>
														{{ $employee->firstname . ' ' . $employee->lastname }}
													</option>

												@endforeach

											</select>
										</div>
									</div>
									<div class="col-12">
										<div class="row">
											<div class="col-xl-6 col-12">
												<div class="mb-1">
													<label class="form-label" for="date_start">
														Başlangıç Tarihi
													</label>
													<input type="text" name="date_start" placeholder="Başlangıç Tarihi" value="{{ $holiday->date_start }}" class="form-control flatpickr-basic" id="date_start">
												</div>
											</div>
											<div class="col-xl-6 col-12">
												<div class="mb-1">
													<label class="form-label" for="date_end">
														Bitiş Tarihi
													</label>
													<input type="text" name="date_end" placeholder="Bitiş Tarihi" value="{{ $holiday->date_end }}" class="form-control flatpickr-basic" id="date_end">
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<button type="submit" class="btn btn-primary waves-effect waves-float waves-light">
							Personel İznini Kaydet
						</button>
					</div>
				</div>
			</form>
		</section>
		<!-- Basic Inputs end -->

	</div>

@endsection

@section('scripts_vendor')
	<script src="{{ asset_url('app/vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>
	<script src="{{ asset_url('app/js/scripts/forms/pickers/tr.js') }}"></script>
@endsection

@section('scripts_page')
@endsection

@section('scripts')
	<script src="{{ asset_url('app/js/scripts/forms/pickers/form-pickers.js') }}"></script>
@endsection
