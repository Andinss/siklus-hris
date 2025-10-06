<nav class="navbar navbar-default">
	<div class="navbar-header">
		{{-- Nav Content --}}
		<div class="nav-content">
			<a class="navbar-brand" href="{{ url('/editor') }}">
				<img src="{{ asset('assets/plugins') }}/images/logo_siklus_hris_horizontal.png"
					alt="logo_siklus_hris_horizontal.png"
					class="primary-logo" />
			</a>
			<a href="javascript:void(0)" class="toggle-sidebar waves-effect" aria-expanded="true">
				<span class="iconify" data-icon="ri:sidebar-fold-line"></span>
			</a>
		</div>
		{{-- End Nav Content --}}

		{{-- Breadcrumbs --}}
		<div class="breadcrumbs">
			<ul class="nav nav-breadcrumb">
				<li>
					<a href="{{ url('/editor') }}">
						<span class="iconify" data-icon="ri:home-line"></span>
					</a>
				</li>
				{{--
                Bagian ini sebelum nya pun tidak muncul, Hapus komen ini jika sudah dibetulkan
				<li>
					<a href="#">@yield('module')</a>
				</li>
                --}}
				<li class="active">
					<p>@yield('title')</p>
				</li>
			</ul>
		</div>
		{{-- End Breadcrumbs --}}

		{{-- Nav Control --}}
		<div class="nav-control">
			{{-- Notification --}}
			<div class="dropdown dropdown-notification">
				<a
					href="javascript:void(0)"
					class="btn btn-light dropdown-toggle remove-caret waves-effect position-relative"
					type="button"
					data-toggle="dropdown"
					aria-expanded="false">
					<span class="iconify" data-icon="ri:notification-3-line"></span>
					<div class="notify">
						<span class="heartbit"></span>
						<span class="point"></span>
					</div>
				</a>
				<div class="dropdown-menu dropdown-menu-right">
					<div class="dropdown-item no-content">
						<div class="illustration">
							<img src="{{ asset('assets/plugins') }}/images/no-notif.png" alt="no-notif.png" />
						</div>
						<p>Tidak ada pemberitahuan hari ini</p>
					</div>
					{{-- <a class="dropdown-item" href="#" target="_blank">
                        Jika terdapat notifikasi
                    </a> --}}
				</div>
			</div>
			{{-- End Notification --}}

			{{-- Profile --}}
			<div class="dropdown dropdown-profile">
				<a href="javascript:void(0)" class="btn btn-light dropdown-toggle waves-effect" type="button"
					data-toggle="dropdown"
					aria-expanded="false">
					<img
						src="{{ asset('uploads') }}/user/{{ Auth::user()->username }}/thumbnail/{{ Auth::user()->filename }}"
						alt="{{ Auth::user()->filename }}"
						class="avatar">
					<span class="name mr-2">
						{{ Auth::user()->username }}
					</span>
				</a>
				<div class="dropdown-menu dropdown-menu-right">
					<a class="dropdown-item waves-effect" href="{{ URL::route('editor.profile.show') }}">
						<span class="iconify" data-icon="ri:user-line"></span>
						Profil Saya
					</a>
					<a
						class="dropdown-item waves-effect"
						href="https://api.whatsapp.com/send?phone=6287717696997&text=Saya%20Pengguna%20Spinel%20"
						target="_blank">
						<span class="iconify" data-icon="ri:whatsapp-line"></span>
						Dukungan
					</a>
					<a class="dropdown-item waves-effect" href="javascript:void(0)" onclick="log_out();">
						<span class="iconify" data-icon="ri:logout-box-r-line"></span>
						Keluar
					</a>
					<form action="{{ url('/logout') }}" id="form_logout" method="POST" style="display: none;">
						{{ csrf_field() }}
					</form>
				</div>
			</div>
			{{-- End Profile --}}
		</div>
		{{-- End Nav Control --}}

	</div>
</nav>
