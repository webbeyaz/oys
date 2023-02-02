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
						Kayıt Silme
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
								Kayıt Silme
							</li>
						</ol>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="content-body">
		<div class="alert alert-{{ $message['class'] }}" role="alert">
			<div class="alert-body">
				{{ $message['text'] }}
			</div>
		</div>
	</div>

@endsection

@section('scripts_vendor')
@endsection

@section('scripts_page')
@endsection

@section('scripts')
@endsection
