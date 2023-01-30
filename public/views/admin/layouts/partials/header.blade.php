<!-- BEGIN: Header-->
<nav class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow container-xxl">
	<div class="navbar-container d-flex content">
		<ul class="nav navbar-nav align-items-center ms-auto">
			<!--<li class="nav-item dropdown dropdown-language">
				<a href="#" class="nav-link dropdown-toggle" id="dropdown-flag" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="flag-icon flag-icon-tr"></i>
					<span class="selected-language">Türkçe</span>
				</a>
				<div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-flag">
					<a class="dropdown-item" href="#" data-language="en">
						<i class="flag-icon flag-icon-us"></i>
						English
					</a>
					<a class="dropdown-item" href="#" data-language="fr">
						<i class="flag-icon flag-icon-fr"></i>
						French
					</a>
					<a class="dropdown-item" href="#" data-language="de">
						<i class="flag-icon flag-icon-de"></i>
						German
					</a>
					<a class="dropdown-item" href="#" data-language="pt">
						<i class="flag-icon flag-icon-pt"></i>
						Portuguese
					</a>
				</div>
			</li>-->
			<li class="nav-item nav-search">
				<a class="nav-link nav-link-search">
					<i class="ficon" data-feather="search"></i>
				</a>
				<div class="search-input">
					<div class="search-input-icon">
						<i data-feather="search"></i>
					</div>
					<input type="text" name="q" placeholder="Ara" class="form-control input" tabindex="-1" data-search="search">
					<div class="search-input-close">
						<i data-feather="x"></i>
					</div>
					<ul class="search-list search-list-main"></ul>
				</div>
			</li>
			<li class="nav-item dropdown dropdown-notification me-25">
				<a href="#" class="nav-link" data-bs-toggle="dropdown">
					<i class="ficon" data-feather="bell"></i>
					<span class="badge rounded-pill bg-danger badge-up">5</span>
				</a>
				<ul class="dropdown-menu dropdown-menu-media dropdown-menu-end">
					<li class="dropdown-menu-header">
						<div class="dropdown-header d-flex">
							<h4 class="notification-title mb-0 me-auto">
								Bildirimler
							</h4>
							<div class="badge rounded-pill badge-light-primary">6 Yeni</div>
						</div>
					</li>
					<li class="scrollable-container media-list">
						<a href="#" class="d-flex">
							<div class="list-item d-flex align-items-start">
								<div class="me-1">
									<div class="avatar">
										<img src="{{ asset_url('app/images/portrait/small/avatar-s-15.jpg') }}" alt="Emin Arif" width="32" height="32">
									</div>
								</div>
								<div class="list-item-body flex-grow-1">
									<p class="media-heading">
										<span class="fw-bolder">Tebrikler Emin Arif 🎉</span>
										bir rozet kazandı!
									</p>
									<small class="notification-text">
										Aylık en iyi personel rozetini kazandı.
									</small>
								</div>
							</div>
						</a>
					</li>
					<li class="dropdown-menu-footer">
						<a class="btn btn-primary w-100" href="#">
							Tüm bildirimleri oku
						</a>
					</li>
				</ul>
			</li>
			<li class="nav-item dropdown dropdown-user">
				<a href="#" class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<div class="user-nav d-sm-flex d-none">
						<span class="user-name fw-bolder">Muhammed</span>
						<span class="user-status">Yönetici</span>
					</div>
					<span class="avatar">
						<img class="round" src="{{ asset_url('app/images/portrait/small/avatar-s-11.jpg') }}" alt="Muhammed" height="40" width="40">
						<span class="avatar-status-online"></span>
					</span>
				</a>
				<div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-user">
					<a href="{{ site_url('admin/users/profile') }}" class="dropdown-item">
						<i class="me-50" data-feather="user"></i>
						Profil
					</a>
					<a href="{{ site_url('admin/employees/tracking') }}" class="dropdown-item">
						<i class="me-50" data-feather="user-check"></i>
						Personel Takibi
					</a>
					<a href="{{ site_url('admin/vehicles/tracking') }}" class="dropdown-item">
						<i class="me-50" data-feather="truck"></i>
						Araç Takibi
					</a>
					<div class="dropdown-divider"></div>
					<a href="{{ site_url('admin/settings') }}" class="dropdown-item">
						<i class="me-50" data-feather="settings"></i>
						Ayarlar
					</a>
					<a href="{{ site_url('admin/faq') }}" class="dropdown-item">
						<i class="me-50" data-feather="help-circle"></i>
						SSS
					</a>
					<a href="{{ site_url('admin/logout') }}" class="dropdown-item">
						<i class="me-50" data-feather="power"></i>
						Çıkış Yap
					</a>
				</div>
			</li>
		</ul>
	</div>
</nav>
<!-- END: Header-->
