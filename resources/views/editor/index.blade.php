@extends('layouts.editor.template')
@section('title', 'Halaman Depan')
@section('content')

	<!-- Page Content -->
	<div id="page-wrapper">
		<div class="container">
			{{-- Row --}}
			<div class="row">
				{{-- Presence Count --}}
				<div class="col-sm-4 mb-3">
					<div class="card card-primary card-summary">
						<div class="card-body">
							<h1 class="summary-title">
								<span id="total-attendances">0</span> / {{ $employee_count->employee_count }}
							</h1>
							<div class="summary-caption">
								<p>Anggota terekam hadir hari ini</p>
								<small class="text-danger">Anda belum melakukan absen hari ini</small>
								{{-- <small class="text-success">Anda telah absen-masuk pada 07.37 WIB</small> --}}
							</div>
						</div>
					</div>
				</div>
				{{-- End Presence Count --}}

				{{-- Full-time Employee --}}
				<div class="col-sm-4 mb-3">
					<div class="card card-primary card-summary">
						<div class="card-body">
							<h1 class="summary-title">{{ $employee_count->employee_count }}</h1>
							<div class="summary-caption">
								<p>Jumlah Anggota tetap</p>
								<small class="text-success">+5% dari tahun lalu</small>
							</div>
						</div>
					</div>
				</div>
				{{-- End Full-time Employee --}}

				{{-- Contract Employee --}}
				<div class="col-sm-4 mb-3">
					<div class="card card-primary card-summary">
						<div class="card-body">
							<h1 class="summary-title">{{ $employee_count->employee_count }}</h1>
							<div class="summary-caption">
								<p>Jumlah Anggota kontrak</p>
								<small class="text-warning">-3% dari tahun lalu</small>
							</div>
						</div>
					</div>
				</div>
				{{-- End Contract Employee --}}

				{{-- Employee Presence --}}
				<div class="col-sm-6 mb-3">
					<div class="card card-user-presence">
						<div class="card-body">
							<p class="card-subheader">Info Kehadiran Anggota</p>
							<div class="presence-container">
								<ul class="nav user-presence-list">
									<li>
										<a href="#" target="_blank" class="waves-effect">
											<div class="user-item">
												<div class="avatar">
													<img src="https://i.pravatar.cc/150?img=4" />
												</div>
												<div class="user-info">
													<p class="name">Terryus gunawan</p>
													<span class="badge badge-pill badge-presence badge-warning">
														<span class="iconify iconify-sm" data-icon="ri:timer-line"></span>
														08:43 - Telat
													</span>
												</div>
												<span class="gimmick-btn">Lihat profil</span>
											</div>
										</a>
									</li>
									<li>
										<a href="#" target="_blank" class="waves-effect">
											<div class="user-item">
												<div class="avatar">
													<img src="https://i.pravatar.cc/150?img=3" />
												</div>
												<div class="user-info">
													<p class="name">Arli Ramdhani</p>
													<span class="badge badge-pill badge-presence badge-success">
														<span class="iconify iconify-sm" data-icon="ri:timer-line"></span>
														07:22 - Masuk
													</span>
												</div>
												<span class="gimmick-btn">Lihat profil</span>
											</div>
										</a>
									</li>
									<li>
										<a href="#" target="_blank" class="waves-effect">
											<div class="user-item">
												<div class="avatar">
													<img src="https://i.pravatar.cc/150?img=10" />
												</div>
												<div class="user-info">
													<p class="name">Mutiara Pasha</p>
													<span class="badge badge-pill badge-presence badge-success">
														<span class="iconify iconify-sm" data-icon="ri:timer-line"></span>
														07:48 - Masuk
													</span>
												</div>
												<span class="gimmick-btn">Lihat profil</span>
											</div>
										</a>
									</li>
									<li>
										<a href="#" target="_blank" class="waves-effect">
											<div class="user-item">
												<div class="avatar">
													<img src="https://i.pravatar.cc/150?img=16" />
												</div>
												<div class="user-info">
													<p class="name">Fitri Kurnia</p>
													<span class="badge badge-pill badge-presence badge-success">
														<span class="iconify iconify-sm" data-icon="ri:timer-line"></span>
														07:26 - Masuk
													</span>
												</div>
												<span class="gimmick-btn">Lihat profil</span>
											</div>
										</a>
									</li>
									<li>
										<a href="#" target="_blank" class="waves-effect">
											<div class="user-item">
												<div class="avatar">
													<img src="https://i.pravatar.cc/150?img=12" />
												</div>
												<div class="user-info">
													<p class="name">Faisal Rahman</p>
													<span class="badge badge-pill badge-presence badge-dark">
														<span class="iconify iconify-sm" data-icon="ri:timer-line"></span>
														--:-- - Absen
													</span>
												</div>
												<span class="gimmick-btn">Lihat profil</span>
											</div>
										</a>
									</li>
									<li><a href="javascript:void(0)" class="py-3 text-center">Lihat info anggota lainnya</a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				{{-- End Employee Presence --}}

				{{-- System Notify --}}
				<div class="col-sm-6 mb-3">
					<div class="card">
						<div class="card-body">
							<p class="card-subheader">
								Selamat datang
								<strong>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</strong>,
							</p>
							<p class="mb-3">Berikut beberapa catatan untuk anda lengkapi:</p>
							<ul class="list-group mb-3">
								<li class="list-group-item">
									<p>Anda belum melakukan absensi</p>
									<a href="#" target="_blank" class="action waves-effect">
										Pergi
										<span class="iconify iconify-sm" data-icon="ri:external-link-line"></span>
									</a>
								</li>
								<li class="list-group-item">
									<p>Laporkan & lengkapi KPI anda</p>
									<a href="#" target="_blank" class="action waves-effect">
										Pergi
										<span class="iconify iconify-sm" data-icon="ri:external-link-line"></span>
									</a>
								</li>
								<li class="list-group-item">
									<p>Lengkapi data diri profil anda</p>
									<a href="#" target="_blank" class="action waves-effect">
										Pergi
										<span class="iconify iconify-sm" data-icon="ri:external-link-line"></span>
									</a>
								</li>
								<li class="list-group-item">
									<p>Perbaharui kata sandi berkala</p>
									<a href="#" target="_blank" class="action waves-effect">
										Pergi
										<span class="iconify iconify-sm" data-icon="ri:external-link-line"></span>
									</a>
								</li>
								<li class="list-group-item">
									<p>Perbaharui kata sandi anda</p>
									<a href="#" target="_blank" class="action waves-effect">
										Pergi
										<span class="iconify iconify-sm" data-icon="ri:external-link-line"></span>
									</a>
								</li>
							</ul>
							<p class="card-note">
								<span class="iconify iconify-sm" data-icon="ri:information-line"></span>
								Kartu saran ini diperbaharui secara otomatis
							</p>
						</div>
					</div>
				</div>
				{{-- End System Notify --}}

				{{-- Gender Chart --}}
				<div class="col-sm-6 mb-3">
					<div class="card">
						<div class="card-body">
							<p class="card-subheader">Jenis Kelamin</p>
							<div style="chart-container">
								<canvas id="chartEmployeeSex"></canvas>
							</div>
						</div>
					</div>
				</div>
				{{-- End Gender Chart --}}

				{{-- Positions Chart --}}
				<div class="col-sm-6 mb-3">
					<div class="card">
						<div class="card-body">
							<p class="card-subheader">Level Jabatan</p>
							<div style="chart-container">
								<canvas id="chartEmployeeDivision"></canvas>
							</div>
						</div>
					</div>
				</div>
				{{-- End Positions Chart --}}
			</div>
			{{-- End Row --}}

			<!-- Employee Summary -->
			<div class="row">
				<div class="col-md-6 mb-3">
					<div class="white-box">
						<div class="row align-items-center mb-2">
							<div class="col-5">
								<h3 class="box-title mb-0">
									<i class="zmdi zmdi-cake"></i>&nbsp;Karyawan Ulang Tahun
								</h3>
							</div>
							<div class="col-7">
								<div class="input-group mb-3">
									{{ Form::text('employee_birth_date_from', old('employee_birth_date_from'), ['class' => 'form-control input-sm btn-sm', 'placeholder' => 'dd-mm-yyyy', 'id' => 'employee_birth_date_from']) }}
									<div class="input-group-append">
										<button type="button"
											class="input-group-text btn btn-1b input-sm btn-sm btn-outline-info waves-effect"
											id="btnSearchBirthEmp">Cari</button>
									</div>
								</div>
							</div>
						</div>
						<ul class="basic-list list-scrollable" id="employee-birthdata">
						</ul>
						<div class="text-center my-4" id="no-content-birthdata">
							<img src="{{ asset('assets/img') }}/img-null.svg" alt="Null Data" class="d-block mx-auto"
								style="height: 120px;" />
							<h4>Tidak ada data karyawan ulang tahun</h4>
						</div>
					</div>
				</div>
				<div class="col-md-6 mb-3">
					<div class="white-box">
						<div class="row align-items-center mb-2">
							<div class="col-5">
								<h3 class="box-title mb-0">
									<i class="zmdi zmdi-accounts-alt"></i>&nbsp;Karyawan Cuti
								</h3>
							</div>
							<div class="col-7">
								<div class="input-group mb-3">
									{{ Form::text('employee_leave_date', old('employee_leave_date'), ['class' => 'form-control date_overtime input-sm btn-sm', 'placeholder' => 'dd-mm-yyyy', 'id' => 'employee_leave_date']) }}
									<div class="input-group-append">
										<button type="button"
											class="input-group-text btn btn-1b input-sm btn-sm btn-outline-info waves-effect"
											id="btnSearchLeaveEmp">Cari</button>
									</div>
								</div>
							</div>
						</div>
						<ul class="basic-list list-scrollable" id="employee-leavedata">
						</ul>
						<div class="text-center my-4" id="no-content-employee-leave">
							<img src="{{ asset('assets/img') }}/img-null.svg" alt="Null Data" class="d-block mx-auto"
								style="height: 120px;" />
							<h4>Tidak ada data karyawan cuti</h4>
						</div>
					</div>
				</div>
			</div>
			<!-- End Employee Summary -->
			<!-- /.row -->
		</div>
		<!-- /.container-fluid -->
	</div>
@stop

@section('scripts')
	<!-- library chart js -->
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

	<script type="text/javascript">
		let absenceDate = $("#absence_date").val();
		$(document).ready(function() {
			$.toast({
				heading: 'Selamat datang di Siklus HRIS',
				text: '{{ Auth::user()->username }}, kami siap membantu anda.',
				position: 'bottom-left',
				loaderBg: '#f2f2f2',
				icon: 'info',
				hideAfter: 7800,
				stack: 8
			});
			jQuery('.mydatepicker, #employee_birth_date_from').datepicker();
			jQuery('.mydatepicker, #employee_birth_date_to').datepicker();
			jQuery('.mydatepicker, #employee_leave_date').datepicker();
			jQuery('.mydatepicker, #absence_date').datepicker();

			$('#employee_birth_date_from').datepicker({
				format: "dd-mm-yyyyy"
			});
			$('#employee_birth_date_to').datepicker({
				format: "dd-mm-yyyyy"
			});
			$('#employee_leave_date').datepicker({
				format: "dd-mm-yyyy"
			});
			$('#absence_date').datepicker({
				format: "dd-mm-yyyy"
			});

			// load function total attendance
			getTotalAttendances(absenceDate);
			// the first load salary
			// getSalary();
		});

		let getTotalAttendances = (absenseDate) => {
			$.ajax({
				url: "{{ route('api.total-attendances') }}",
				type: "POST",
				dataType: "json",
				data: {
					date_in: absenseDate
				},
				success: function(res) {
					// console.log(res[0].total_attendances)
					$("#total-attendances").text(res[0].total_attendances);
				},
				error: function(xhr) {
					console.log(xhr.responseText)
				}
			});
		}
		$(document).on('click', '#btnSearchTotalAttendances', function(event) {
			event.preventDefault();
			let dateIn = $("#absence_date").val();
			getTotalAttendances(dateIn)
		});

		let loadImage = (variable) => {

			if (variable == null) {
				return `<a class="fancybox" rel="group" target="_blank" href="{{ asset('assets/plugins') }}/images/employee_icon.png"> <img src="{{ asset('assets/plugins') }}/images/employee_icon.png" class="img-thumbnail img-responsive img-employee-sm" alt="employee-image" /></a>`;
			} else {
				return ` <a class="fancybox" rel="group" target="_blank" href="{{ asset('uploads/employee') }}/${variable}"> <img src="{{ asset('uploads/employee') }}/${variable}" class="img-thumbnail img-responsive img-employee-sm" alt="employee-image"/></a>`;
			}
		}

		// function add 30 days
		function addDays(dateString) {
			let date = new Date();
			let days;

			let dateFormat = formatDate(dateString, '-');
			let d = new Date(dateFormat);

			let month = d.getMonth() + 1;
			switch (month) {
				case 1:
					days = 30;
					break;
				case 2:
					days = 27;
					break;
				case 3:
					days = 30;
					break;
				case 4:
					days = 29;
					break;
				case 5:
					days = 30;
					break;
				case 6:
					days = 29;
					break;
				case 7:
					days = 30;
					break;
				case 8:
					days = 30;
					break;
				case 9:
					days = 29;
					break;
				case 10:
					days = 30;
					break;
				case 11:
					days = 29;
					break;
				case 12:
					days = 30;
					break;
				default:
					break;
			}

			d.setDate(d.getDate() + days);
			// console.log(days);
			return d.toLocaleDateString();
		}

		function formatDate(dateString, separator) {

			// Split the date string into separate parts (day, month, year)
			const parts = dateString.split(separator);

			// Check if the format is correct (DD-MM-YYYY) or (DD/MM/YYYY)
			if (parts.length !== 3) {
				throw new Error("Invalid date format. Please use DD-MM-YYYY or DD/MM/YYYY.");
			}

			const day = parts[0].padStart(2, '0');
			const month = parts[1].padStart(2, '0');
			const year = parts[2];
			// Reassemble the date in YYYY-MM-DD format
			if (separator == '-') {
				return `${year}-${month}-${day}`;
			} else {
				return `${day}-${month}-${year}`;
			}

		}

		$(document).on('click', '#btnSearchBirthEmp', function(e) {
			e.preventDefault();
			let birthDateFrom = $("#employee_birth_date_from").val();
			let nextToThirtyDays = addDays(birthDateFrom);
			let birthDateTo = formatDate(nextToThirtyDays, '/');
			// console.log(birthDateFrom);
			// console.log(birthDateTo);

			let output;
			$.ajax({
				url: "{{ route('api.search-employee-birth-data') }}",
				type: "POST",
				data: {
					birth_date_from: birthDateFrom,
					birth_date_to: birthDateTo
				},
				dataType: 'json',
				success: function(res) {
					// console.log(res);

					if (res.length < 1) {
						output = `<img src="{{ asset('assets/img') }}/img-null.svg" alt="Null Data" class="d-block mx-auto" style="height: 120px;" />
                        <h4>Tidak ada data karyawan ulang tahun</h4>`;
						$("#employee-birthdata").addClass('hide');
						$("#no-content-birthdata").html(output);
					} else {
						res.map((row) => {
							output += ` <li class="py-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    ${loadImage(row.image)}
                                    <div class="ml-3">
                                        <h5 class="mb-0">${row.employee_name}</h5>
                                        <i>${row.staff_status_name}</i>
                                    </div>
                                </div>
                                <span class="pull-right label-info label">${row.date_birth}</span>
                            </div>
                        </li>`;
						})

						$("#no-content-birthdata").html('');
						$("#employee-birthdata").removeClass('hide');
						$("#employee-birthdata").html(output);
					}
				}
			})
		});

		$(document).on('click', '#btnSearchLeaveEmp', function(e) {
			e.preventDefault();
			let leaveDate = $("#employee_leave_date").val();

			let output;
			$.ajax({
				url: "{{ route('api.search-employee-leave-data') }}",
				type: "POST",
				data: {
					date_trans: leaveDate
				},
				dataType: 'json',
				success: function(res) {
					// console.log(res);

					if (res.length < 1) {
						output = `<img src="{{ asset('assets/img') }}/img-null.svg" alt="Null Data" class="d-block mx-auto" style="height: 120px;" />
                        <h4>Tidak ada data karyawan cuti</h4>`;
						$("#employee-leavedata").addClass('hide');
						$("#no-content-employee-leave").html(output);
					} else {
						res.map((row) => {
							output += ` <li class="py-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <a class="fancybox" rel="group" target="_blank" href="{{ asset('uploads/employee') }}/${row.image}">
                                        ${loadImage(row.image)}
                                    </a>
                                    <div class="ml-3">
                                        <h5 class="mb-0">${row.employee_name}</h5>
                                        <i>${row.staff_status_name}</i>
                                    </div>
                                </div>
                                <div>
                                    <span class="label-success label">${row.leave_from}</span>
                                    <span>s/d</span>
                                    <span class="label-success label">${row.leave_to}</span>
                                </div>
                            </div>
                        </li>`;
						})

						$("#no-content-employee-leave").html('');
						$("#employee-leavedata").removeClass('hide');
						$("#employee-leavedata").html(output);
					}
				}
			})
		});

		// Get Employee Sex
		const chart_employee_sex = () => {
			const employee_sex = document.getElementById('chartEmployeeSex').getContext("2d");

			$.ajax({
				url: "{{ URL::route('api.total-genders') }}",
				type: "GET",
				dataType: "json",
				success: function(res) {
					// console.log(res)
					let totals = [];

					// set chart
					new Chart(employee_sex, {
						type: 'doughnut',
						data: {
							labels: res.map((row) => row.sex_name),
							datasets: [{
								label: ' %',
								data: res.map((row) => row.sum_sex),
								backgroundColor: ['#3184ff', '#DC0091'],
								hoverOffset: 4
							}]
						},
						options: {
							aspectRatio: 3 / 2
						}
					});
				},
				error: function(xhr, textStatus) {
					console.log(xhr.responseText)
				}
			})

		}
		chart_employee_sex();

		// Get Division
		const chart_employee_division = () => {
			const employee_divison = document.getElementById('chartEmployeeDivision').getContext("2d");
			$.ajax({
				url: "{{ URL::route('api.employee-level') }}",
				type: "GET",
				dataType: "json",
				success: function(res) {
					// console.log(res);
					// set chart
					new Chart(employee_divison, {
						type: 'bar',
						data: {
							labels: res.map((row) => row.staff_status_name),
							datasets: [{
								label: 'Level Jabatan',
								data: res.map((row) => row.sum_staff_status),
								backgroundColor: '#41b6d3',
								hoverOffset: 4,
								borderWidth: 1
							}]
						},
						options: {
							indexAxis: 'y',
							plugins: {
								legend: {
									display: true,
									position: 'top'
								}
							},
							aspectRatio: 3 / 2,
							scales: {
								y: {
									beginAtZero: true
								}
							}
						}
					});
				},
				error: function(xhr, textStatus) {
					console.log(xhr.responseText)
				}
			})

		}
		chart_employee_division();
	</script>
@stop
