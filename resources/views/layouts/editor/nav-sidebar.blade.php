<!-- Left navbar-header -->
<div class="sidebar">
	<div class="sidebar-content">
		<ul class="nav sidebar-menu" id="side-menu">
			<li>
				{{-- You can add class active for active page --}}
				<a href="{{ URL::route('editor.index') }}" class="waves-effect">
					<span class="iconify" data-icon="ri:home-line"></span>
					Home
				</a>
			</li>
			<li>
				<p class="sidebar-header">Aktivitas Karyawan</p>
			</li>
			<li class="collapsible">
				<a
					class="waves-effect"
					data-toggle="collapse"
					href="#collapseEmployee"
					role="button"
					aria-expanded="false"
					aria-controls="collapseEmployee">
					<span class="iconify" data-icon="ri:group-3-line"></span>
					Karyawan
				</a>
				<div class="collapse" id="collapseEmployee">
					<div class="card card-body p-0 border-0">
						<ul class="nav sidebar-menu sub">
							@actionStart('karyawan', 'read')
							<li>
								<a href="{{ URL::route('editor.employee.index') }}" class="waves-effect">
									<span class="iconify" data-icon="ph:dot-outline"></span>
									Data Karyawan
								</a>
							</li>
							@actionEnd

							@actionStart('pengaturan_karyawan', 'read')
							<li class="collapsible">
								<a
									class="waves-effect"
									data-toggle="collapse"
									href="#collapseEmployeeConfig"
									role="button"
									aria-expanded="false"
									aria-controls="collapseEmployeeConfig">
									<span class="iconify" data-icon="ph:dot-outline"></span>
									Pengaturan
								</a>
								<div class="collapse" id="collapseEmployeeConfig">
									<div class="card card-body p-0 border-0">
										<ul class="nav sidebar-menu sub">
											<li>
												<a href="{{ URL::route('editor.employee-status.index') }}" class="waves-effect">
													Status Karyawan
												</a>
											</li>
											<li>
												<a href="{{ URL::route('editor.department.index') }}" class="waves-effect">
													Divisi
												</a>
											</li>
											<li>
												<a href="{{ URL::route('editor.position.index') }}" class="waves-effect">
													Jabatan
												</a>
											</li>
											<li>
												<a href="{{ URL::route('editor.education-level.index') }}" class="waves-effect">
													Jenjang Pendidikan
												</a>
											</li>
											<li>
												<a href="{{ URL::route('editor.education-major.index') }}" class="waves-effect">
													Jurusan Pendidikan
												</a>
											</li>
											<li>
												<a href="{{ URL::route('editor.ptkp.index') }}" class="waves-effect">
													PTKP
												</a>
											</li>
										</ul>
									</div>
								</div>
							</li>
							@actionEnd
						</ul>
					</div>
				</div>
			</li>

			<li class="collapsible">
				<a
					class="waves-effect"
					data-toggle="collapse"
					href="#collapseActivity"
					role="button"
					aria-expanded="false"
					aria-controls="collapseActivity">
					<span class="iconify" data-icon="ri:open-arm-line"></span>
					Aktivitas
				</a>
				<div class="collapse" id="collapseActivity">
					<div class="card card-body p-0 border-0">
						<ul class="nav sidebar-menu sub">
							@actionStart('pelatihan', 'read')
							<li>
								<a href="{{ URL::route('editor.training.index') }}" class="waves-effect">
									<span class="iconify" data-icon="ph:dot-outline"></span>
									Pelatihan
								</a>
							</li>
							@actionEnd
							@actionStart('dokumen', 'read')
							<li>
								<a href="{{ URL::route('editor.document.index') }}" class="waves-effect">
									<span class="iconify" data-icon="ph:dot-outline"></span>
									Dokumen
								</a>
							</li>
							@actionEnd
							@actionStart('penghargaan', 'read')
							<li>
								<a href="{{ URL::route('editor.reward.index') }}" class="waves-effect">
									<span class="iconify" data-icon="ph:dot-outline"></span>
									Penghargaan
								</a>
							</li>
							@actionEnd
							@actionStart('teguran', 'read')
							<li>
								<a href="{{ URL::route('editor.punishment.index') }}" class="waves-effect">
									<span class="iconify" data-icon="ph:dot-outline"></span>
									Teguran
								</a>
							</li>
							@actionEnd
							@actionStart('acara', 'read')
							<li>
								<a href="{{ URL::route('editor.event.index') }}" class="waves-effect">
									<span class="iconify" data-icon="ph:dot-outline"></span>
									Acara
								</a>
							</li>
							@actionEnd
							@actionStart('pengaturan_aktivitas', 'read')
							<li class="collapsible">
								<a
									class="waves-effect"
									data-toggle="collapse"
									href="#collapseActivityConfig"
									role="button"
									aria-expanded="false"
									aria-controls="collapseActivityConfig">
									<span class="iconify" data-icon="ph:dot-outline"></span>
									Pengaturan
								</a>
								<div class="collapse" id="collapseActivityConfig">
									<div class="card card-body p-0 border-0">
										<ul class="nav sidebar-menu sub">
											<li>
												<a href="{{ URL::route('editor.training-provider.index') }}" class="waves-effect">
													Pemberi Pelatihan
												</a>
											</li>
											<li>
												<a href="{{ URL::route('editor.location.index') }}" class="waves-effect">
													Lokasi
												</a>
											</li>
										</ul>
									</div>
								</div>
							</li>
							@actionEnd
						</ul>
					</div>
				</div>
			</li>

			<li class="collapsible">
				<a
					class="waves-effect"
					data-toggle="collapse"
					href="#collapseAbsence"
					role="button"
					aria-expanded="false"
					aria-controls="collapseAbsence">
					<span class="iconify" data-icon="ri:map-pin-time-line"></span>
					Absensi
				</a>
				<div class="collapse" id="collapseAbsence">
					<div class="card card-body p-0 border-0">
						<ul class="nav sidebar-menu sub">
							<li>
								<a href="{{ URL::route('editor.absence-location.index') }}" class="waves-effect">
									<span class="iconify" data-icon="ph:dot-outline"></span>
									Kelola Lokasi
								</a>
							</li>
							@actionStart('kelola_absensi', 'read')
							<li>
								<a href="{{ URL::route('editor.time.index') }}" class="waves-effect">
									<span class="iconify" data-icon="ph:dot-outline"></span>
									Laporan Absensi
								</a>
							</li>
							@actionEnd
							@actionStart('jadwal_shift', 'read')
							<li>
								<a href="{{ URL::route('editor.shift-plan.index') }}" class="waves-effect">
									<span class="iconify" data-icon="ph:dot-outline"></span>
									Jadwal Shift
								</a>
							</li>
							@actionEnd
							@actionStart('lembur', 'read')
							<li>
								<a href="{{ URL::route('editor.overtime.index') }}" class="waves-effect">
									<span class="iconify" data-icon="ph:dot-outline"></span>
									Lembur
								</a>
							</li>
							@actionEnd
							@actionStart('ijin', 'read')
							<li>
								<a href="{{ URL::route('editor.leave.index') }}" class="waves-effect">
									<span class="iconify" data-icon="ph:dot-outline"></span>
									Ijin
								</a>
							</li>
							@actionEnd
							@actionStart('pengaturan_absensi', 'read')
							<li class="collapsible">
								<a
									class="waves-effect"
									data-toggle="collapse"
									href="#collapseAbsenceConfig"
									role="button"
									aria-expanded="false"
									aria-controls="collapseAbsenceConfig">
									<span class="iconify" data-icon="ph:dot-outline"></span>
									Pengaturan
								</a>
								<div class="collapse" id="collapseAbsenceConfig">
									<div class="card card-body p-0 border-0">
										<ul class="nav sidebar-menu sub">
											<li>
												<a href="{{ URL::route('editor.absence-type.index') }}" class="waves-effect">
													Jenis Absensi
												</a>
											</li>
											<li>
												<a href="{{ URL::route('editor.holiday.index') }}" class="waves-effect">
													Hari Libur
												</a>
											</li>
											<li>
												<a href="{{ URL::route('editor.overtime-type.index') }}" class="waves-effect">
													Jenis Lembur
												</a>
											</li>
											<li>
												<a href="{{ URL::route('editor.shift.index') }}" class="waves-effect">
													Shift
												</a>
											</li>
											<li>
												<a href="{{ URL::route('editor.shift-group.index') }}" class="waves-effect">
													Grup Shift
												</a>
											</li>
											<li>
												<a href="{{ URL::route('editor.absence-period.index') }}" class="waves-effect">
													Periode Absensi
												</a>
											</li>
										</ul>
									</div>
								</div>
							</li>
							@actionEnd
						</ul>
					</div>
				</div>
			</li>

			<li>
				<p class="sidebar-header">Keuangan</p>
			</li>
			<li class="collapsible">
				<a
					class="waves-effect"
					data-toggle="collapse"
					href="#collapseSalary"
					role="button"
					aria-expanded="false"
					aria-controls="collapseSalary">
					<span class="iconify" data-icon="ri:bank-card-line"></span>
					Gaji
				</a>
				<div class="collapse" id="collapseSalary">
					<div class="card card-body p-0 border-0">
						<ul class="nav sidebar-menu sub">
							@actionStart('gaji', 'read')
							<li>
								<a href="{{ URL::route('editor.payroll.index') }}" class="waves-effect">
									<span class="iconify" data-icon="ph:dot-outline"></span>
									Gaji
								</a>
							</li>
							@actionEnd
							@actionStart('tinjauan_gaji', 'read')
							<li>
								<a href="{{ URL::route('editor.payroll-report.index') }}" class="waves-effect">
									<span class="iconify" data-icon="ph:dot-outline"></span>
									Tinjauan Gaji
								</a>
							</li>
							@actionEnd
							@actionStart('pengaturan_gaji', 'read')
							<li class="collapsible">
								<a
									class="waves-effect"
									data-toggle="collapse"
									href="#collapseSalaryConfig"
									role="button"
									aria-expanded="false"
									aria-controls="collapseSalaryConfig">
									<span class="iconify" data-icon="ph:dot-outline"></span>
									Pengaturan
								</a>
								<div class="collapse" id="collapseSalaryConfig">
									<div class="card card-body p-0 border-0">
										<ul class="nav sidebar-menu sub">
											<li>
												<a href="{{ URL::route('editor.payroll-slip.index') }}" class="waves-effect">
													Slip Gaji
												</a>
											</li>
											<li>
												<a href="{{ URL::route('editor.payroll-type.index') }}" class="waves-effect">
													Jenis Gaji
												</a>
											</li>
											<li>
												<a href="{{ URL::route('editor.payroll-component.index') }}" class="waves-effect">
													Komponen Gaji
												</a>
											</li>
											<li>
												<a href="{{ URL::route('editor.bpjs-tk.index') }}" class="waves-effect">
													BPJS TK
												</a>
											</li>
											<li>
												<a href="{{ URL::route('editor.bpjs-kesehatan.index') }}" class="waves-effect">
													BPJS Kesehatan
												</a>
											</li>
											<li>
												<a href="{{ URL::route('editor.period.index') }}" class="waves-effect">
													Periode
												</a>
											</li>
										</ul>
									</div>
								</div>
							</li>
							@actionEnd
						</ul>
					</div>
				</div>
			</li>

			<li class="collapsible">
				<a
					class="waves-effect"
					data-toggle="collapse"
					href="#collapseClaim"
					role="button"
					aria-expanded="false"
					aria-controls="collapseClaim">
					<span class="iconify" data-icon="ri:bank-card-line"></span>
					Klaim
				</a>
				<div class="collapse" id="collapseClaim">
					<div class="card card-body p-0 border-0">
						<ul class="nav sidebar-menu sub">
							@actionStart('klaim', 'read')
							<li>
								<a href="{{ URL::route('editor.reimburse.index') }}" class="waves-effect">
									<span class="iconify" data-icon="ph:dot-outline"></span>
									Permintaan Klaim
								</a>
							</li>
							<li>
								<a href="{{ URL::route('editor.reimburse-approval.index') }}" class="waves-effect">
									<span class="iconify" data-icon="ph:dot-outline"></span>
									Persetujuan Klaim
								</a>
							</li>
							@actionEnd
							<li class="collapsible">
								<a
									class="waves-effect"
									data-toggle="collapse"
									href="#collapseClaimConfig"
									role="button"
									aria-expanded="false"
									aria-controls="collapseClaimConfig">
									<span class="iconify" data-icon="ph:dot-outline"></span>
									Pengaturan
								</a>
								<div class="collapse" id="collapseClaimConfig">
									<div class="card card-body p-0 border-0">
										<ul class="nav sidebar-menu sub">
											<li>
												<a href="{{ URL::route('editor.reimburse-type') }}" class="waves-effect">
													Jenis Klaim
												</a>
											</li>
										</ul>
									</div>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</li>

			<li>
				<p class="sidebar-header">Manajemen pengguna</p>
			</li>
			<li class="collapsible">
				<a
					class="waves-effect"
					data-toggle="collapse"
					href="#collapseUser"
					role="button"
					aria-expanded="false"
					aria-controls="collapseUser">
					<span class="iconify" data-icon="ri:user-line"></span>
					User
				</a>
				<div class="collapse" id="collapseUser">
					<div class="card card-body p-0 border-0">
						<ul class="nav sidebar-menu sub">
							<li>
								<a href="{{ URL::route('editor.user.index') }}" class="waves-effect">
									<span class="iconify" data-icon="ph:dot-outline"></span>
									User
								</a>
							</li>
							<li>
								<a href="{{ URL::route('editor.module.index') }}" class="waves-effect">
									<span class="iconify" data-icon="ph:dot-outline"></span>
									Modul
								</a>
							</li>
							<li>
								<a href="{{ URL::route('editor.privilege.index') }}" class="waves-effect">
									<span class="iconify" data-icon="ph:dot-outline"></span>
									Hak Akses
								</a>
							</li>
						</ul>
					</div>
				</div>
			</li>
			<li class="collapsible">
				<a
					class="waves-effect"
					data-toggle="collapse"
					href="#collapseLog"
					role="button"
					aria-expanded="false"
					aria-controls="collapseLog">
					<span class="iconify" data-icon="ri:node-tree"></span>
					Log
				</a>
				<div class="collapse" id="collapseLog">
					<div class="card card-body p-0 border-0">
						<ul class="nav sidebar-menu sub">
							<li>
								<a href="{{ URL::route('editor.userlog.index') }}" class="waves-effect">
									<span class="iconify" data-icon="ph:dot-outline"></span>
									User Log Data
								</a>
							</li>
							<li>
								<a href="{{ URL::route('editor.userlog.form') }}" class="waves-effect">
									<span class="iconify" data-icon="ph:dot-outline"></span>
									Send Log Data
								</a>
							</li>
						</ul>
					</div>
				</div>
			</li>

			<li>
				<a href="{{ URL::route('editor.preference.edit', 1) }}" class="waves-effect">
					<span class="iconify" data-icon="ri:eye-2-line"></span>
					Preferensi
				</a>
			</li>
		</ul>
	</div>
</div>
