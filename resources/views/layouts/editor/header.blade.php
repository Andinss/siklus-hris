<div id="wrapper">
	<!-- Navigation -->
	<nav class="navbar navbar-default navbar-static-top m-b-0">
		<div class="navbar-header">
			<a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse"
				data-target=".navbar-collapse"><i class="ti-menu"></i></a>
			<div class="top-left-part">
				<a class="logo" href="{{ url('/editor') }}">
					<img src="{{ asset('assets/plugins') }}/images/logo_siklus_hris_horizontal.png" alt="Siklus HRIS" />
				</a>
			</div>
			<ul class="nav navbar-top-links navbar-left hidden-xs">
				<li>
					<a href="javascript:void(0)" class="btn btn-outline-dark open-close hidden-xs waves-effect"
						style="width: 40px;">
						<i class="fa fa-arrow-left mr-0"></i>
					</a>
				</li>
			</ul>
			<ul class="nav navbar-top-links navbar-right pull-right">
				<!-- /.dropdown -->
				<li class="dropdown">
					<a class="btn btn-outline-dark dropdown-toggle waves-effect waves-light" data-toggle="dropdown"
						href="#" style="width: 40px;">
						<i class="fa fa-bell mr-0"></i>
						<div class="notify">
							<span class="heartbit"></span>
							<span class="point"></span>
						</div>
					</a>
					<ul class="dropdown-menu dropdown-tasks scale-up">
						<li>
							<div class="drop-title">Tidak ada pemberitahuan hari ini</div>
						</li>
						<li>
							<a href="#">
								<div>
									<a href="#">
										<div class="mail-contnet" style="width: 50%;">
											<img src="{{ asset('assets/plugins') }}/images/task.png" alt="home" />
										</div>
									</a>
								</div>
							</a>
						</li>
					</ul>
					<!-- /.dropdown-tasks -->
				</li>
				<!-- /.dropdown -->
				<li class="dropdown">
					<a class="btn btn-outline-primary dropdown-toggle profile-pic" data-toggle="dropdown"
						href="#">
						<img src="{{ asset('uploads') }}/user/{{ Auth::user()->username }}/thumbnail/{{ Auth::user()->filename }}"
							alt="" width="28" class="img-circle mr-md-2">
						<b class="base-sm hidden-xs">{{ Auth::user()->username }}</b>
						<i class="fa fa-chevron-down ml-2"></i>
					</a>
					<ul class="dropdown-menu dropdown-user scale-up">
						<li><a href="{{ URL::route('editor.profile.show') }}"><i class="ti-user"></i> Profil Saya</a>
						</li>
						<li><a href="https://api.whatsapp.com/send?phone=6287717696997&text=Saya%20Pengguna%20Spinel%20"
								target="_blank"><i class="zmdi zmdi-whatsapp text-success"></i> Dukungan</a></li>
						<li><a href="#" onclick="log_out();"><i class="ti-power-off text-danger"></i> Keluar</a>
						</li>
						<form action="{{ url('/logout') }}" id="form_logout" method="POST" style="display: none;">
							{{ csrf_field() }}
							<button style="margin-left: 10px" class="btn btn-danger btn-flat"><i
									class="fa fa-sign-out"></i> Keluar</button>
						</form>
					</ul>
					<!-- /.dropdown-user -->
				</li>
			</ul>
		</div>
		<!-- /.navbar-header -->
		<!-- /.navbar-top-links -->
		<!-- /.navbar-static-side -->
	</nav>
	<!-- Left navbar-header -->
	<div class="navbar-default sidebar" role="navigation">
		<div class="sidebar-nav navbar-collapse slimscrollsidebar">
			<ul class="nav" id="side-menu">
				<li>
					<a href="{{ URL::route('editor.index') }}" class="waves-effect"><i class="fas fa-home fa-fw"></i>
						<span class="hide-menu">Home</span></a>
				</li>
				<li class="nav-small-cap mt-2">--- Aktivitas Karyawan</li>
				<li>
					<a href="{{ URL::route('editor.employee.index') }}" class="waves-effect"><i
							class="fas fa-users fa-fw"></i> <span class="hide-menu">Karyawan</span><span
							class="hide-menu"><span class="fa arrow"></span></span></a>
					<ul class="nav nav-second-level">
						@actionStart('karyawan', 'read')
						<li> <a href="{{ URL::route('editor.employee.index') }}">Data Karyawan</a></li>
						@actionEnd
						@actionStart('pengaturan_karyawan', 'read')
						<li><a href="javascript:void(0)" class="waves-effect">Pengaturan<span
									class="fa arrow"></span></a>
							<ul class="nav nav-third-level">
								<li><a href="{{ URL::route('editor.employee-status.index') }}">Status Karyawan</a></li>
								<li><a href="{{ URL::route('editor.department.index') }}">Divisi</a></li>
								<li><a href="{{ URL::route('editor.position.index') }}">Jabatan</a></li>
								<li><a href="{{ URL::route('editor.education-level.index') }}">Jenjang Pendidikan</a>
								</li>
								<li><a href="{{ URL::route('editor.education-major.index') }}">Jurusan Pendidikan</a>
								</li>
								<li><a href="{{ URL::route('editor.ptkp.index') }}">PTKP</a></li>
							</ul>
						</li>
						@actionEnd
					</ul>
				</li>
				</li>
				<li> <a href="#" class="waves-effect"><i class="fas fa-list-ul fa-fw"></i> <span
							class="hide-menu">Aktivitas</span><span class="hide-menu"><span
								class="fa arrow"></span></span></a>
					<ul class="nav nav-second-level">
						@actionStart('pelatihan', 'read')
						<li> <a href="{{ URL::route('editor.training.index') }}">Pelatihan</a></li>
						@actionEnd
						@actionStart('dokumen', 'read')
						<li> <a href="{{ URL::route('editor.document.index') }}">Dokumen</a></li>
						@actionEnd
						@actionStart('penghargaan', 'read')
						<li> <a href="{{ URL::route('editor.reward.index') }}">Penghargaan</a></li>
						@actionEnd
						@actionStart('teguran', 'read')
						<li> <a href="{{ URL::route('editor.punishment.index') }}">Teguran</a></li>
						@actionEnd
						@actionStart('acara', 'read')
						<li> <a href="{{ URL::route('editor.event.index') }}">Acara</a></li>
						@actionEnd
						@actionStart('pengaturan_aktivitas', 'read')
						<li><a href="javascript:void(0)" class="waves-effect">Pengaturan<span
									class="fa arrow"></span></a>
							<ul class="nav nav-third-level">
								<li><a href="{{ URL::route('editor.training-provider.index') }}">Pemberi Pelatihan</a>
								</li>
								<li><a href="{{ URL::route('editor.location.index') }}">Lokasi</a></li>
							</ul>
						</li>
						@actionEnd
					</ul>
				</li>
				<li> <a href="javascript:void(0)" class="waves-effect"><i class="fas fa-fingerprint fa-fw"></i> <span
							class="hide-menu">Absensi<span class="fa arrow"></span></span></a>
					<ul class="nav nav-second-level">
						<li><a href="{{ URL::route('editor.absence-location.index') }}">Kelola Lokasi</a></li>
						@actionStart('kelola_absensi', 'read')
						<li><a href="{{ URL::route('editor.time.index') }}">Laporan Absensi</a></li>
						@actionEnd
						@actionStart('jadwal_shift', 'read')
						<li><a href="{{ URL::route('editor.shift-plan.index') }}">Jadwal Shift</a></li>
						@actionEnd
						@actionStart('lembur', 'read')
						<li><a href="{{ URL::route('editor.overtime.index') }}">Lembur</a></li>
						@actionEnd
						@actionStart('ijin', 'read')
						<li><a href="{{ URL::route('editor.leave.index') }}">Ijin</a></li>
						@actionEnd
						@actionStart('pengaturan_absensi', 'read')
						<li> <a href="javascript:void(0)" class="waves-effect">Pengaturan <span
									class="fa arrow"></span></a>
							<ul class="nav nav-third-level">
								<li><a href="{{ URL::route('editor.absence-type.index') }}">Jenis Absensi</a></li>
								<li><a href="{{ URL::route('editor.holiday.index') }}">Hari Libur</a></li>
								<li><a href="{{ URL::route('editor.overtime-type.index') }}">Jenis Lembur</a></li>
								<li><a href="{{ URL::route('editor.shift.index') }}">Shift</a></li>
								<li><a href="{{ URL::route('editor.shift-group.index') }}">Grup Shift</a></li>
								<li><a href="{{ URL::route('editor.absence-period.index') }}">Periode Absensi</a></li>
							</ul>
						</li>
						@actionEnd
					</ul>
				</li>

				<li class="nav-small-cap mt-2">--- Keuangan</li>
				<li> <a href="javascript:void(0)" class="waves-effect"><i
							class="fas fa-money-bill-wave-alt fa-fw"></i> <span class="hide-menu">Gaji<span
								class="fa arrow"></span></span></a>
					<ul class="nav nav-second-level">
						@actionStart('gaji', 'read')
						<li><a href="{{ URL::route('editor.payroll.index') }}">Gaji</a></li>
						@actionEnd
						@actionStart('tinjauan_gaji', 'read')
						<li><a href="{{ URL::route('editor.payroll-report.index') }}">Tinjauan Gaji</a></li>
						@actionEnd
						@actionStart('pengaturan_gaji', 'read')
						<li> <a href="javascript:void(0)" class="waves-effect">Pengaturan <span
									class="fa arrow"></span></a>
							<ul class="nav nav-third-level">
								<li><a href="{{ URL::route('editor.payroll-slip.index') }}">Slip Gaji</a></li>
								<li><a href="{{ URL::route('editor.payroll-type.index') }}">Jenis Gaji</a></li>
								<li><a href="{{ URL::route('editor.payroll-component.index') }}">Komponen Gaji</a>
								</li>
								<li><a href="{{ URL::route('editor.bpjs-tk.index') }}">BPJS TK</a></li>
								<li><a href="{{ URL::route('editor.bpjs-kesehatan.index') }}">BPJS Kesehatan</a></li>
								<li><a href="{{ URL::route('editor.period.index') }}">Periode</a></li>
							</ul>
						</li>
						@actionEnd
					</ul>
				</li>
				<li> <a href="#" class="waves-effect"><i class="fas fa-credit-card fa-fw"></i> <span
							class="hide-menu">Klaim</span><span class="hide-menu"><span
								class="fa arrow"></span></span></a>
					<ul class="nav nav-second-level">
						@actionStart('klaim', 'read')
						<li> <a href="{{ URL::route('editor.reimburse.index') }}">Permintaan Klaim</a></li>
						<li> <a href="{{ URL::route('editor.reimburse-approval.index') }}">Persetujuan Klaim</a></li>
						@actionEnd

						<li><a href="#" class="waves-effect">Pengaturan <span class="fa arrow"></span></a>
							<ul class="nav nav-third-level">
								<li><a href="{{ URL::route('editor.reimburse-type') }}">Jenis Klaim</a></li>
							</ul>
						</li>

					</ul>
				</li>
				<li class="nav-small-cap mt-2">--- Manajamen Pengguna</li>
				<li> <a href="#" class="waves-effect"><i class="fas fa-users-cog fa-fw"></i> <span
							class="hide-menu">User</span><span class="hide-menu"><span
								class="fa arrow"></span></span></a>
					<ul class="nav nav-second-level">
						<li> <a href="{{ URL::route('editor.user.index') }}">User</a></li>
						<li> <a href="{{ URL::route('editor.module.index') }}">Modul</a></li>
						<li> <a href="{{ URL::route('editor.privilege.index') }}">Hak Akses</a></li>
					</ul>
				</li>
				<li> <a href="#" class="waves-effect"><i class="fas fa-history fa-fw" data-icon="n"></i>
						<span class="hide-menu">Log</span><span class="hide-menu"><span
								class="fa arrow"></span></span></a>
					<ul class="nav nav-second-level">
						<li> <a href="{{ URL::route('editor.userlog.index') }}"> User Log Data</a></li>
						<li> <a href="{{ URL::route('editor.userlog.form') }}">Send Log Data</a></li>
					</ul>
				</li>
				<li>
					<a href="{{ URL::route('editor.preference.edit', 1) }}" class="waves-effect"><i
							class="fas fa-cog fa-fw" data-icon="&#xe011;"></i> <span
							class="hide-menu">Preferensi</span></a>
				</li>
			</ul>
		</div>
	</div>
</div>
