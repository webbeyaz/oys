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
						Kullanıcı Düzenle
					</h2>
					<div class="breadcrumb-wrapper">
						<ol class="breadcrumb">
							<li class="breadcrumb-item">
								<a href="{{ site_url('admin/dashboard') }}">
									Anasayfa
								</a>
							</li>
							<li class="breadcrumb-item">
								<a href="{{ site_url('admin/users/list') }}">
									Kullanıcılar
								</a>
							</li>
							<li class="breadcrumb-item active">
								Kullanıcı Düzenle
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
									Kullanıcı Düzenle
								</h4>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-xl-6 col-12">
										<div class="mb-1">
											<label class="form-label" for="username">
												Kullanıcı Adı
											</label>
											<input type="text" name="username" placeholder="Kullanıcı Adı" value="{{ $item->username }}" required class="form-control" id="username">
										</div>
									</div>
									<div class="col-xl-6 col-12">
										<div class="mb-1">
											<label class="form-label" for="password">
												Şifre
											</label>
											<input type="password" name="password" placeholder="Şifre" class="form-control" id="password">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-xl-6 col-12">
										<div class="mb-1">
											<label class="form-label" for="firstname">
												Ad
											</label>
											<input type="text" name="firstname" placeholder="Ad" value="{{ $item->firstname }}" required class="form-control" id="firstname">
										</div>
									</div>
									<div class="col-xl-6 col-12">
										<div class="mb-1">
											<label class="form-label" for="lastname">
												Soyad
											</label>
											<input type="text" name="lastname" placeholder="Soyad" value="{{ $item->lastname }}" required class="form-control" id="lastname">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-xl-6 col-12">
										<div class="mb-1">
											<label class="form-label" for="email">
												E-posta
											</label>
											<input type="email" name="email" placeholder="E-posta" value="{{ $item->email }}" required class="form-control" id="email">
										</div>
									</div>
									<div class="col-xl-6 col-12">
										<div class="mb-1">
											<label class="form-label" for="phone">
												Telefon
											</label>
											<input type="text" name="phone" placeholder="Telefon" value="{{ $item->phone }}" class="form-control" id="phone">
										</div>
									</div>
								</div>
							</div>
						</div>
						<button type="submit" class="btn btn-primary waves-effect waves-float waves-light">
							Kullanıcıyı Kaydet
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
