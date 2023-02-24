@extends('admin.layouts.default')

@section('title', 'Ofis Yönetim Sistemi')

@section('styles_vendor')
	<link rel="stylesheet" type="text/css" href="{{ asset_url('app/vendors/css/file-uploaders/dropzone.min.css') }}">
@endsection

@section('styles_page')
	<link rel="stylesheet" type="text/css" href="{{ asset_url('app/css/core/menu/menu-types/vertical-menu.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset_url('app/css/pages/app-ecommerce.css') }}">
@endsection

@section('styles')

	<style>
		.ecommerce-application .grid-view:not(.wishlist-items),
		.ecommerce-application .list-view:not(.wishlist-items) {
			margin-top: 0;
		}
	</style>

@endsection

@section('content')

	<div class="content-header row">
		<div class="content-header-left col-12 mb-2">
			<div class="row breadcrumbs-top">
				<div class="col-12">
					<h2 class="content-header-title float-start mb-0">
						Kayıt Düzenle
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
								Kayıt Düzenle
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
									Kayıt Düzenle
								</h4>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-xl-6 col-12">
										<div class="mb-1">
											<label class="form-label" for="vehicle_id">
												Şoför
											</label>
											<select type="text" name="vehicle_id" class="form-control" id="vehicle_id">

												@foreach ($vehicles as $vehicle)

													<option value="{{ $vehicle->id }}" {{ $vehicle->id == $event->vehicle_id ? 'selected' : null }}>
														{{ $vehicle->plate }}
													</option>

												@endforeach

											</select>
										</div>
										<div class="mb-1">
											<label class="form-label" for="text">
												Açıklama
											</label>
											<textarea name="text" placeholder="Açıklama" class="form-control" id="text">{{ $event->text }}</textarea>
										</div>
									</div>
									<div class="col-xl-6 col-12">
										<div class="mb-1">
											<label class="form-label" for="text">
												Resim(ler)
											</label>
											<input type="file" name="images[]" accept="image/*" multiple class="form-control">
										</div>

										@if ($images)

											<div class="mb-1">
												<div class="ecommerce-application">
													<div class="grid-view">

														@foreach ($images as $image)

															<div class="card ecommerce-card">
																<div class="item-img text-center">
																	<img src="{{ upload_url('images/cache/events/400x400/' . $image->image) }}" alt="{{ $image->id }}" class="img-fluid card-img-top">
																</div>
																<div class="item-options text-center">
																	<a href="{{ upload_url('images/original/events/' . $image->image) }}" target="_blank" class="btn btn-light btn-wishlist">
																		<i data-feather="eye"></i>
																		<span>Görüntüle</span>
																	</a>
																	<a href="{{ upload_url('images/original/events/' . $image->image) }}" download class="btn btn-primary btn-cart">
																		<i data-feather="download"></i>
																		<span class="add-to-cart">İndir</span>
																	</a>
																</div>
															</div>

														@endforeach

													</div>
												</div>
											</div>

										@endif

									</div>
								</div>
							</div>
						</div>
						<button type="submit" class="btn btn-primary waves-effect waves-float waves-light">
							Kaydı Kaydet
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
