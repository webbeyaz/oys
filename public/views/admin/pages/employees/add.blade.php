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
						Personel Ekle
					</h2>
					<div class="breadcrumb-wrapper">
						<ol class="breadcrumb">
							<li class="breadcrumb-item">
								<a href="{{ site_url('admin') }}">
									Anasayfa
								</a>
							</li>
							<li class="breadcrumb-item">
								<a href="{{ site_url('admin/employees/list') }}">
									Personeller
								</a>
							</li>
							<li class="breadcrumb-item active">
								Personel Ekle
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
								Personel Ekle
							</h4>
						</div>
						<div class="card-body">
							<form action="" method="post">
								<div class="row">
									<div class="col-xl-6 col-12">
										<div class="mb-1">
											<label class="form-label" for="username">
												Kullanıcı Adı
											</label>
											<input type="text" name="username" placeholder="Kullanıcı Adı" class="form-control" id="username">
										</div>
										<div class="mb-1">
											<label class="form-label" for="password">
												Şifre
											</label>
											<input type="password" name="password" placeholder="Şifre" class="form-control" id="password">
										</div>
									</div>
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
								</div>
								<div class="row mt-1">
									<div class="col-xl-6 col-12">
										<div class="mb-1">
											<label class="form-label mb-1" for="photo">
												<img src="{{ asset_url('app/images/avatars/default.jpg') }}" alt="Fotoğraf" width="60" height="60" class="avatar">
											</label>
											<input type="file" name="photo" class="form-control" id="photo">
										</div>
									</div>
									<div class="col-xl-6 col-12 d-flex align-items-end">
										<div class="mb-1">
											<div class="form-check form-switch">
												<input type="checkbox" name="status" checked class="form-check-input" id="status">
												<label class="form-check-label" for="status">
													Durum
												</label>
											</div>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
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
