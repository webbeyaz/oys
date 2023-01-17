@extends('panel.layouts.auth')

@section('title', 'Panel :: HaxMonster')
@section('description', 'Description.')

@section('styles')
@endsection

@section('content')

	<!-- Page body -->
	<div class="modern-login">
		<div class="underlay h-hidden-mobile h-hidden-tablet-p"></div>
		<div class="columns is-gapless is-vcentered">
			<div class="column is-relative is-8 h-hidden-mobile h-hidden-tablet-p">
				<div class="hero is-fullheight is-image">
					<div class="hero-body">
						<div class="container">
							<div class="columns">
								<div class="column">
									<img src="{{ asset_url('panel/img/illustrations/login/station.svg') }}" alt="Station" class="hero-image">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="column is-4 is-relative">
				<a href="{{ site_url('panel/login') }}" class="top-logo">
					<img src="{{ asset_url('panel/img/logos/logo/logo.svg') }}" alt="HaxMonster" class="light-image">
					<img src="{{ asset_url('panel/img/logos/logo/logo-light.svg') }}" alt="HaxMonster" class="dark-image">
				</a>
				<label class="dark-mode ml-auto">
					<input type="checkbox" checked>
					<span></span>
				</label>
				<div class="is-form">
					<div class="hero-body">
						<div class="form-text">
							<h2>
								Login to Panel
							</h2>
							<p>
								Welcome back to your account.
							</p>
						</div>
						<div class="form-text is-hidden">
							<h2>
								Recover Account
							</h2>
							<p>
								Reset your account password.
							</p>
						</div>
						<form action="" method="post" class="login-wrapper" id="login-form">
							<div class="control has-validation">
								<input type="text" name="username" class="input">
								<small class="error-text">
									This is a required field
								</small>
								<div class="auth-label">
									Username
								</div>
								<div class="auth-icon">
									<i class="lnil lnil-user"></i>
								</div>
								<div class="validation-icon is-success">
									<div class="icon-wrapper">
										<i data-feather="check"></i>
									</div>
								</div>
								<div class="validation-icon is-error">
									<div class="icon-wrapper">
										<i data-feather="x"></i>
									</div>
								</div>
							</div>
							<div class="control has-validation">
								<input type="password" name="password" class="input">
								<div class="auth-label">
									Password
								</div>
								<div class="auth-icon">
									<i class="lnil lnil-lock-alt"></i>
								</div>
							</div>
							<div class="control is-flex">
								<label class="remember-toggle">
									<input type="checkbox">
									<span class="toggler">
												<span class="active">
													<i data-feather="check"></i>
												</span>
												<span class="inactive">
													<i data-feather="circle"></i>
												</span>
											</span>
								</label>
								<div class="remember-me">
									Remember Me
								</div>
								<a id="forgot-link">
									Forgot Password?
								</a>
							</div>
							<div class="button-wrap">
								<button type="button" class="button h-button is-big is-rounded is-primary is-bold is-raised" id="login-submit">
									Login
								</button>
							</div>
						</form>
						<form class="login-wrapper is-hidden" id="recover-form">
							<p class="recover-text">
								Enter your username and click on the confirm button to reset your password.
								We'll send you an email detailing the steps to complete the procedure.
							</p>
							<div class="control has-validation">
								<input type="text" name="username" class="input">
								<small class="error-text">This is a required field</small>
								<div class="auth-label">
									Username
								</div>
								<div class="auth-icon">
									<i class="lnil lnil-user"></i>
								</div>
								<div class="validation-icon is-success">
									<div class="icon-wrapper">
										<i data-feather="check"></i>
									</div>
								</div>
								<div class="validation-icon is-error">
									<div class="icon-wrapper">
										<i data-feather="x"></i>
									</div>
								</div>
							</div>
							<div class="button-wrap">
								<button type="button" class="button h-button is-white is-big is-rounded is-lower" id="cancel-recover">
									Cancel
								</button>
								<button type="button" class="button h-button is-solid is-big is-rounded is-lower is-raised is-colored">
									Confirm
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

@section('scripts')
@endsection
