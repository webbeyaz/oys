<!-- BEGIN: Header-->
<nav class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow container-xxl">
	<div class="navbar-container d-flex content">
		<div class="bookmark-wrapper d-flex align-items-center">
			<ul class="nav navbar-nav d-xl-none">
				<li class="nav-item">
					<a class="nav-link menu-toggle" href="#">
						<i class="ficon" data-feather="menu"></i>
					</a>
				</li>
			</ul>
			<ul class="nav navbar-nav bookmark-icons">
				<li class="nav-item d-none d-lg-block">
					<a class="nav-link" href="app-email.html" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Email">
						<i class="ficon" data-feather="mail"></i>
					</a>
				</li>
				<li class="nav-item d-none d-lg-block">
					<a class="nav-link" href="app-chat.html" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Chat">
						<i class="ficon" data-feather="message-square"></i>
					</a>
				</li>
				<li class="nav-item d-none d-lg-block">
					<a class="nav-link" href="app-calendar.html" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Calendar">
						<i class="ficon" data-feather="calendar"></i>
					</a>
				</li>
				<li class="nav-item d-none d-lg-block">
					<a class="nav-link" href="app-todo.html" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Todo">
						<i class="ficon" data-feather="check-square"></i>
					</a>
				</li>
			</ul>
			<ul class="nav navbar-nav">
				<li class="nav-item d-none d-lg-block">
					<a class="nav-link bookmark-star">
						<i class="ficon text-warning" data-feather="star"></i>
					</a>
					<div class="bookmark-input search-input">
						<div class="bookmark-input-icon">
							<i data-feather="search"></i>
						</div>
						<input type="text" name="q" placeholder="Yer imleri" class="form-control input" tabindex="0" data-search="search">
						<ul class="search-list search-list-bookmark"></ul>
					</div>
				</li>
			</ul>
		</div>
		<ul class="nav navbar-nav align-items-center ms-auto">
			<li class="nav-item dropdown dropdown-language">
				<a href="#" class="nav-link dropdown-toggle" id="dropdown-flag" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="flag-icon flag-icon-tr"></i>
					<span class="selected-language">Türkçe</span>
				</a>
				<!--<div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-flag">
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
				</div>-->
			</li>
			<li class="nav-item nav-search">
				<a class="nav-link nav-link-search">
					<i class="ficon" data-feather="search"></i>
				</a>
				<div class="search-input">
					<div class="search-input-icon">
						<i data-feather="search"></i>
					</div>
					<input type="text" placeholder="Ara" class="form-control input" tabindex="-1" data-search="search">
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
							<div class="badge rounded-pill badge-light-primary">6 New</div>
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
						<span class="user-status">Yönetici</span></div>
					<span class="avatar">
							<img class="round" src="{{ asset_url('app/images/portrait/small/avatar-s-11.jpg') }}" alt="Muhammed" height="40" width="40">
							<span class="avatar-status-online"></span>
						</span>
				</a>
				<div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-user">
					<a href="page-profile.html" class="dropdown-item">
						<i class="me-50" data-feather="user"></i>
						Profil
					</a>
					<a href="app-todo.html" class="dropdown-item">
						<i class="me-50" data-feather="check-square"></i>
						Personel Takibi
					</a>
					<a href="app-chat.html" class="dropdown-item">
						<i class="me-50" data-feather="message-square"></i>
						Araç Takibi
					</a>
					<div class="dropdown-divider"></div>
					<a href="page-account-settings-account.html" class="dropdown-item">
						<i class="me-50" data-feather="settings"></i>
						Ayarlar
					</a>
					<a href="page-faq.html" class="dropdown-item">
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
<ul class="main-search-list-defaultlist d-none">
	<li class="d-flex align-items-center">
		<a href="#">
			<h6 class="section-label mt-75 mb-0">
				Dosyalar
			</h6>
		</a>
	</li>
	<li class="auto-suggestion">
		<a href="app-file-manager.html" class="d-flex align-items-center justify-content-between w-100">
			<div class="d-flex">
				<div class="me-75">
					<img src="{{ asset_url('app/images/icons/xls.png') }}" alt="Excel" height="32">
				</div>
				<div class="search-data">
					<p class="search-data-title mb-0">
						İki yeni öğe gönderildi
					</p>
					<small class="text-muted">
						Muhammed
					</small>
				</div>
			</div>
			<small class="search-data-size me-50 text-muted">
				&apos;17kb
			</small>
		</a>
	</li>
	<li class="auto-suggestion">
		<a class="d-flex align-items-center justify-content-between w-100" href="app-file-manager.html">
			<div class="d-flex">
				<div class="me-75"><img src="../../../app-assets/images/icons/jpg.png" alt="png" height="32"></div>
				<div class="search-data">
					<p class="search-data-title mb-0">52 JPG file Generated</p>
					<small class="text-muted">FontEnd Developer</small>
				</div>
			</div>
			<small class="search-data-size me-50 text-muted">&apos;11kb</small>
		</a>
	</li>
	<li class="auto-suggestion">
		<a class="d-flex align-items-center justify-content-between w-100" href="app-file-manager.html">
			<div class="d-flex">
				<div class="me-75"><img src="../../../app-assets/images/icons/pdf.png" alt="png" height="32"></div>
				<div class="search-data">
					<p class="search-data-title mb-0">25 PDF File Uploaded</p>
					<small class="text-muted">Digital Marketing Manager</small>
				</div>
			</div>
			<small class="search-data-size me-50 text-muted">&apos;150kb</small>
		</a>
	</li>
	<li class="auto-suggestion">
		<a class="d-flex align-items-center justify-content-between w-100" href="app-file-manager.html">
			<div class="d-flex">
				<div class="me-75"><img src="../../../app-assets/images/icons/doc.png" alt="png" height="32"></div>
				<div class="search-data">
					<p class="search-data-title mb-0">Anna_Strong.doc</p>
					<small class="text-muted">Web Designer</small>
				</div>
			</div>
			<small class="search-data-size me-50 text-muted">&apos;256kb</small>
		</a>
	</li>
	<li class="d-flex align-items-center">
		<a href="#">
			<h6 class="section-label mt-75 mb-0">Members</h6>
		</a>
	</li>
	<li class="auto-suggestion">
		<a class="d-flex align-items-center justify-content-between py-50 w-100" href="app-user-view-account.html">
			<div class="d-flex align-items-center">
				<div class="avatar me-75"><img src="../../../app-assets/images/portrait/small/avatar-s-8.jpg" alt="png" height="32"></div>
				<div class="search-data">
					<p class="search-data-title mb-0">John Doe</p>
					<small class="text-muted">UI designer</small>
				</div>
			</div>
		</a>
	</li>
	<li class="auto-suggestion">
		<a class="d-flex align-items-center justify-content-between py-50 w-100" href="app-user-view-account.html">
			<div class="d-flex align-items-center">
				<div class="avatar me-75"><img src="../../../app-assets/images/portrait/small/avatar-s-1.jpg" alt="png" height="32"></div>
				<div class="search-data">
					<p class="search-data-title mb-0">Michal Clark</p>
					<small class="text-muted">FontEnd Developer</small>
				</div>
			</div>
		</a>
	</li>
	<li class="auto-suggestion">
		<a class="d-flex align-items-center justify-content-between py-50 w-100" href="app-user-view-account.html">
			<div class="d-flex align-items-center">
				<div class="avatar me-75"><img src="../../../app-assets/images/portrait/small/avatar-s-14.jpg" alt="png" height="32"></div>
				<div class="search-data">
					<p class="search-data-title mb-0">Milena Gibson</p>
					<small class="text-muted">Digital Marketing Manager</small>
				</div>
			</div>
		</a>
	</li>
	<li class="auto-suggestion">
		<a class="d-flex align-items-center justify-content-between py-50 w-100" href="app-user-view-account.html">
			<div class="d-flex align-items-center">
				<div class="avatar me-75"><img src="../../../app-assets/images/portrait/small/avatar-s-6.jpg" alt="png" height="32"></div>
				<div class="search-data">
					<p class="search-data-title mb-0">Anna Strong</p>
					<small class="text-muted">Web Designer</small>
				</div>
			</div>
		</a>
	</li>
</ul>
<ul class="main-search-list-defaultlist-other-list d-none">
	<li class="auto-suggestion justify-content-between">
		<a class="d-flex align-items-center justify-content-between w-100 py-50">
			<div class="d-flex justify-content-start"><span class="me-75" data-feather="alert-circle"></span><span>No results found.</span></div>
		</a>
	</li>
</ul>
<!-- END: Header-->
