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
		<div class="content-header-left col-12 mb-2">
			<div class="row breadcrumbs-top">
				<div class="col-12">
					<h2 class="content-header-title float-start mb-0">
						Şoför Ekle
					</h2>
					<div class="breadcrumb-wrapper">
						<ol class="breadcrumb">
							<li class="breadcrumb-item">
								<a href="{{ site_url('admin/dashboard') }}">
									Anasayfa
								</a>
							</li>
							<li class="breadcrumb-item">
								<a href="{{ site_url('admin/drivers/list') }}">
									Şoförler
								</a>
							</li>
							<li class="breadcrumb-item active">
								Şoför Ekle
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
									Şoför Ekle
								</h4>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-xl-6 col-12">
										<div class="mb-1">
											<label class="form-label" for="firstname">
												Ad
											</label>
											<input type="text" name="firstname" placeholder="Ad" class="form-control" id="firstname">
										</div>
										<div class="mb-1">
											<label class="form-label" for="lastname">
												Soyad
											</label>
											<input type="text" name="lastname" placeholder="Soyad" class="form-control" id="lastname">
										</div>
									</div>
									<div class="col-xl-6 col-12">
										<div class="mb-1">
											<label class="form-label" for="email">
												E-posta Adresi
											</label>
											<input type="email" name="email" placeholder="E-posta Adresi" class="form-control" id="email">
										</div>
										<div class="mb-1">
											<label class="form-label" for="phone">
												Telefon Numarası
											</label>
											<input type="text" name="phone" placeholder="Telefon Numarası" class="form-control" id="phone">
										</div>
									</div>
									<div class="col-12">
										<div class="mb-1">
											<label class="form-label" for="vehicle_id">
												Araç
											</label>
											<select name="vehicle_id" class="form-control" id="vehicle_id">
												<option value="" selected>
													Plaka Seçiniz
												</option>

												@foreach ($vehicles as $vehicle)

													<option value="{{ $vehicle->id }}">
														{{ $vehicle->plate }}
													</option>

												@endforeach

											</select>
										</div>
									</div>
								</div>
							</div>
						</div>
						<button type="submit" class="btn btn-primary waves-effect waves-float waves-light">
							Şoför Ekle
						</button>
					</div>
				</div>
			</form>
		</section>
		<!-- Basic Inputs end -->

	</div>

@endsection

@section('scripts_vendor')
@endsection

@section('scripts_page')
@endsection

@section('scripts')
@endsection
