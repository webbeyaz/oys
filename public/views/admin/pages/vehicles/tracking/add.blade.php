@extends('admin.layouts.default')

@section('title', 'Ofis Yönetim Sistemi')

@section('styles_vendor')
	<link rel="stylesheet" type="text/css" href="{{ asset_url('app/vendors/css/file-uploaders/dropzone.min.css') }}">
@endsection

@section('styles_page')
	<link rel="stylesheet" type="text/css" href="{{ asset_url('app/css/core/menu/menu-types/vertical-menu.css') }}">
@endsection

@section('styles')
@endsection

@section('content')

	<div class="content-header row">
		<div class="content-header-left col-12 mb-2">
			<div class="row breadcrumbs-top">
				<div class="col-12">
					<h2 class="content-header-title float-start mb-0">
						Kayıt Ekle
					</h2>
					<div class="breadcrumb-wrapper">
						<ol class="breadcrumb">
							<li class="breadcrumb-item">
								<a href="{{ site_url('admin/dashboard') }}">
									Anasayfa
								</a>
							</li>
							<li class="breadcrumb-item">
								<a href="{{ site_url('admin/vehicles/tracking') }}">
									Araç Takibi
								</a>
							</li>
							<li class="breadcrumb-item active">
								Kayıt Ekle
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

			<form action="" method="post" enctype="multipart/form-data">

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
									Kayıt Ekle
								</h4>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-xl-6 col-12">
										<div class="mb-1">
											<label class="form-label" for="vehicle_id">
												Araç
											</label>
											<select type="text" name="vehicle_id" class="form-control" id="vehicle_id">

												@foreach ($vehicles as $vehicle)

													<option value="{{ $vehicle->id }}">
														{{ $vehicle->plate }}
													</option>

												@endforeach

											</select>
										</div>
										<div class="mb-1">
											<label class="form-label" for="text">
												Açıklama
											</label>
											<textarea name="text" placeholder="Açıklama" class="form-control" id="text"></textarea>
										</div>
									</div>
									<div class="col-xl-6 col-12">
										<div class="mb-1">
											<label class="form-label" for="text">
												Resim(ler)
											</label>
											<input type="file" name="images[]" accept="image/*" multiple class="form-control">
										</div>
									</div>
								</div>
							</div>
						</div>
						<button type="submit" class="btn btn-primary waves-effect waves-float waves-light">
							Kayıt Ekle
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
