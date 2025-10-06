@extends('layouts.editor.template')
@section('module', 'Setting')
@section('title', 'Gaji')
@section('title', 'Tinjauan Gaji')
@section('content')
    <style type="text/css">
        .jq-icon-info {
            background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR…b0vjdyFT4Cxk3e/kIqlOGoVLwwPevpYHT+00T+hWwXDf4AJAOUqWcDhbwAAAAASUVORK5CYII=);
            background-color: #75D7F0;
            color: #2b2b2b;
            border-color: #75D7F0;
        }
    </style>
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">@yield('title')</h4>
                </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ url('/editor') }}">Dashboard</a></li>
                        <li><a href="#">@yield('module')</a></li>
                        <li class="active">@yield('title')</li>
                    </ol>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

            <!-- Payroll Insight -->
            <div id="payrollInsight">
                <div class="row justify-content-between align-items-center mb-3 mb-md-4">
                    <div class="col-12 col-md-5 col-lg-4 mb-3 mb-md-0">
                        <h3 class="font-weight-bold my-0">Tinjauan Gaji</h3>
                    </div>
                    <div class="col-12 col-md-5 col-lg-4 mb-3 mb-md-0">
                        <div class="row">
                            <div class="col-12 col-md-7 mb-2 mb-md-0">
                                {{-- {{ Form::text('salary_year', old('salary_year', date('Y')), array('class' => 'form-control salary_year', 'placeholder' => 'contoh: 2024', 'id' => 'salary_year', 'onchange' => 'handleYearChange(this.value)')) }} --}}

                                <?php
                                $currentYear = date('Y');
                                ?>
                                <select name="salary_year" id="salary_year" class="form-control salary_year"
                                    onchange="handleYearChange(this.value)">
                                    @for ($year = $currentYear; $year >= $currentYear - 4; $year--)
                                        <option value="{{ $year }}"
                                            {{ old('salary_year', $currentYear) == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-12 col-md-5">
                                <button type="button" id="generatePayrollToPDF" class="btn btn-primary mb-0">Download PDF
                                    <i class="ml-2 fa fa-download"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="payrollInsightReport">
                    <div class="row white-box">
                        <div class="col-12">
                            <h3 class="font-weight-semibold text-info text-center mt-0">Gaji</h3>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <h3 class="box-title">Gaji Pokok</h3>
                            <div style="width:100%;">
                                <canvas id="chartMainSalary"></canvas>
                            </div>
                            <table id="tableMainSalary" class="table table-sm mt-3 table__payroll-insight">
                                <thead>
                                    <tr>
                                        <th>Bulan</th>
                                        <th>Rp</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBodyMainSalary">
                                    <!-- Data will be inserted here -->
                                </tbody>
                            </table>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <h3 class="box-title">Gaji Bruto</h3>
                            <div style="width:100%;">
                                <canvas id="chartBrutoSalary"></canvas>
                            </div>
                            <table id="tableBrutoSalary" class="table table-sm mt-3 table__payroll-insight">
                                <thead>
                                    <tr>
                                        <th>Bulan</th>
                                        <th>Rp</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBodyBrutoSalary">
                                    <!-- Data will be inserted here -->
                                </tbody>
                            </table>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <h3 class="box-title">Take Home Pay</h3>
                            <div style="width:100%;">
                                <canvas id="chartTakeHomePay"></canvas>
                            </div>
                            <table id="tableTakeHomePay" class="table table-sm mt-3 table__payroll-insight">
                                <thead>
                                    <tr>
                                        <th>Bulan</th>
                                        <th>Rp</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBodyTakeHomePay">
                                    <!-- Data will be inserted here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row white-box">
                        <div class="col-12">
                            <h3 class="font-weight-semibold text-success text-center mt-0">Tunjangan & Bonus</h3>
                        </div>
                        <div class="col-12 col-md-6">
                            <h3 class="box-title">Lembur</h3>
                            <div style="width:100%;">
                                <canvas id="chartBenefitOvertime"></canvas>
                            </div>
                            <table id="tableBenefitOvertime" class="table table-sm mt-3 table__payroll-insight">
                                <thead>
                                    <tr>
                                        <th>Bulan</th>
                                        <th>Rp</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBodyBenefitOvertime">
                                    <!-- Data will be inserted here -->
                                </tbody>
                            </table>
                        </div>
                        <div class="col-12 col-md-6">
                            <h3 class="box-title">Uang Makan</h3>
                            <div style="width:100%;">
                                <canvas id="chartBenefitLunch"></canvas>
                            </div>
                            <table id="tableBenefitLunch" class="table table-sm mt-3 table__payroll-insight">
                                <thead>
                                    <tr>
                                        <th>Bulan</th>
                                        <th>Rp</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBodyBenefitLunch">
                                    <!-- Data will be inserted here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row white-box">
                        <div class="col-12">
                            <h3 class="font-weight-semibold text-danger text-center mt-0">Potongan</h3>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <h3 class="box-title">BPJS Ketenagakerjaan</h3>
                            <div style="width:100%;">
                                <canvas id="chartDuesBPJSKetenagakerjaan"></canvas>
                            </div>
                            <table id="tableDuesBPJSKetenagakerjaan" class="table table-sm mt-3 table__payroll-insight">
                                <thead>
                                    <tr>
                                        <th>Bulan</th>
                                        <th>Rp</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBodyDuesBPJSKetenagakerjaan">
                                    <!-- Data will be inserted here -->
                                </tbody>
                            </table>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <h3 class="box-title">BPJS Kesehatan</h3>
                            <div style="width:100%;">
                                <canvas id="chartDuesBPJSKesehatan"></canvas>
                            </div>
                            <table id="tableDuesBPJSKesehatan" class="table table-sm mt-3 table__payroll-insight">
                                <thead>
                                    <tr>
                                        <th>Bulan</th>
                                        <th>Rp</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBodyDuesBPJSKesehatan">
                                    <!-- Data will be inserted here -->
                                </tbody>
                            </table>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <h3 class="box-title">PPH 21</h3>
                            <div style="width:100%;">
                                <canvas id="chartDuesPPH21"></canvas>
                            </div>
                            <table id="tableDuesPPH21" class="table table-sm mt-3 table__payroll-insight">
                                <thead>
                                    <tr>
                                        <th>Bulan</th>
                                        <th>Rp</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBodyDuesPPH21">
                                    <!-- Data will be inserted here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Payroll Insight -->

        </div>
        <!-- /.container-fluid -->
    </div>
@stop


@section('scripts')
    <!-- library chart js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- HTML2Canvas -->
    <script src="https://unpkg.com/jspdf@latest/dist/jspdf.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jspdf-html2canvas@latest/dist/jspdf-html2canvas.min.js"></script>

    <script type="text/javascript">
        let year = $("#salary_year").val();
        $(document).ready(function() {
            func_chart_data_basic_salary(year);
            func_chart_data_bruto(year);
            func_chart_data_thp(year);
            func_chart_data_overtime(year);
            func_chart_data_meal_trans(year);
            func_chart_data_jamsostek(year);
            func_chart_data_bpjs(year);
            func_chart_data_pph21(year);
        })

        function handleYearChange(year) {
            // Validasi input, pastikan hanya tahun yang valid (4 digit angka)
            if (!/^\d{4}$/.test(year)) {
                alert("Tahun tidak valid. Masukkan format tahun seperti 2024.");
                return;
            }

            // Panggil fungsi chart untuk berbagai kategori
            func_chart_data_basic_salary(year);
            func_chart_data_bruto(year);
            func_chart_data_thp(year);
            func_chart_data_overtime(year);
            func_chart_data_meal_trans(year);
            func_chart_data_jamsostek(year);
            func_chart_data_bpjs(year);
            func_chart_data_pph21(year);
        }
        // Payroll Insight
        // Main Salary
        // let datas = [];
        let months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober',
            'November', 'Desember'
        ];
        // for (let datas_index = 0; datas_index <= 11; ++datas_index) {
        //     datas.push(Math.random() * (500) + 500);
        // }
        // Generate Charts
        let myChart;
        const generate_chart_payroll = (element_id, label, color, datas) => {
            let chartStatus = Chart.getChart(element_id); // <canvas> id
            if (chartStatus != undefined) {
                chartStatus.destroy();
            }

            const chart = document.getElementById(element_id).getContext("2d");
            // set chart
            myChart = new Chart(chart, {
                type: 'line',
                data: {
                    labels: datas.map((row) => row.description),
                    datasets: [{
                        label: label,
                        data: datas.map((row) => row.total),
                        backgroundColor: color,
                        hoverOffset: 4,
                        borderWidth: 1
                    }]
                },
                options: {
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

        }
        // generate_chart_payroll('chartMainSalary', 'Gaji Pokok', '#00CADC');
        // generate_chart_payroll('chartBrutoSalary', 'Gaji Bruto', '#00CADC');
        // generate_chart_payroll('chartTakeHomePay', 'Take Home Pay', '#00CADC');
        // generate_chart_payroll('chartBenefitOvertime', 'Lembur', '#00BF63');
        // generate_chart_payroll('chartBenefitLunch', 'Uang Makan', '#00BF63');
        // generate_chart_payroll('chartDuesBPJSKetenagakerjaan', 'BPJS Ketenagakerjaan', '#DC0091');
        // generate_chart_payroll('chartDuesBPJSKesehatan', 'BPJS Kesehatan', '#DC0091');
        // generate_chart_payroll('chartDuesPPH21', 'PPH 21', '#DC0091');

        // Create Table
        var table_payroll = document.querySelectorAll(".table__payroll-insight");
        table_payroll.forEach(function(table_item) {
            table_item.classList.add("d-none");
        })
        // console.log(table_payroll);
        const generate_table = (table_body_name, datas) => {
            let data_table = [];
            tableBody = document.getElementById(table_body_name);
            // push data
            datas.forEach(function(row) {
                data_table.push({
                    month: row.description,
                    data: row.total
                })
            })
            // insert table data
            data_table.forEach(function(item) {
                var row = document.createElement("tr");

                var monthCell = document.createElement("td");
                monthCell.classList.add("font-weight-semibold");
                monthCell.textContent = item.month;
                row.appendChild(monthCell);

                var dataCell = document.createElement("td");
                dataCell.textContent = item.data;
                row.appendChild(dataCell);

                tableBody.appendChild(row);
            });
        }
        // generate_table('tableBodyMainSalary');
        // generate_table('tableBodyBrutoSalary');
        // generate_table('tableBodyTakeHomePay');
        // generate_table('tableBodyBenefitOvertime');
        // generate_table('tableBodyBenefitLunch');
        // generate_table('tableBodyDuesBPJSKetenagakerjaan');
        // generate_table('tableBodyDuesBPJSKesehatan');
        // generate_table('tableBodyDuesPPH21');

        // Export to PDF
        const generate_to_pdf = (file_name) => {
            let btn = document.getElementById('generatePayrollToPDF');
            let page = document.getElementById('payrollInsightReport');

            btn.addEventListener('click', function() {
                table_payroll.forEach(function(table_item) {
                    table_item.classList.remove("d-none");
                })

                html2PDF(page, {
                    jsPDF: {
                        format: 'a4',
                    },
                    imageType: 'image/jpeg',
                    output: `${file_name}.pdf`
                });
            });
        }
        generate_to_pdf('tinjauan-gaji-' + year + '');


        // load chart
        let func_chart_data_basic_salary = (salary_year) => {
            $.ajax({
                url: "{{ route('api.payroll-report.data-basic') }}",
                type: "POST",
                dataType: "json",
                data: {
                    year: salary_year
                },
                success: function(res) {
                    let rows = res;
                    generate_chart_payroll('chartMainSalary', 'Gaji Pokok', '#00CADC', rows);
                    generate_table('tableBodyMainSalary', rows);
                }
            })
        }

        let func_chart_data_bruto = (salary_year) => {

            $.ajax({
                url: "{{ route('api.payroll-report.data-bruto') }}",
                type: "POST",
                dataType: "json",
                data: {
                    year: salary_year
                },
                success: function(res) {
                    let rows = res;
                    generate_chart_payroll('chartBrutoSalary', 'Gaji Bruto', '#00CADC', rows);
                    generate_table('tableBodyBrutoSalary', rows);
                }
            })
        }

        let func_chart_data_thp = (salary_year) => {

            $.ajax({
                url: "{{ route('api.payroll-report.data-thp') }}",
                type: "POST",
                dataType: "json",
                data: {
                    year: salary_year
                },
                success: function(res) {
                    let rows = res;
                    generate_chart_payroll('chartTakeHomePay', 'Take Home Pay', '#00CADC', rows);
                    generate_table('tableBodyTakeHomePay', rows);
                }
            })
        }

        let func_chart_data_overtime = (salary_year) => {
            if (myChart != null) {
                myChart.destroy();
            }
            $.ajax({
                url: "{{ route('api.payroll-report.data-overtime') }}",
                type: "POST",
                dataType: "json",
                data: {
                    year: salary_year
                },
                success: function(res) {
                    let rows = res;
                    generate_chart_payroll('chartBenefitOvertime', 'Lembur', '#00BF63', rows);
                    generate_table('tableBodyBenefitOvertime', rows);
                }
            })
        }

        let func_chart_data_meal_trans = (salary_year) => {

            $.ajax({
                url: "{{ route('api.payroll-report.data-meal-trans') }}",
                type: "POST",
                dataType: "json",
                data: {
                    year: salary_year
                },
                success: function(res) {
                    let rows = res;
                    generate_chart_payroll('chartBenefitLunch', 'Uang Makan', '#00BF63', rows);
                    generate_table('tableBodyBenefitLunch', rows);
                }
            })
        }

        let func_chart_data_jamsostek = (salary_year) => {

            $.ajax({
                url: "{{ route('api.payroll-report.data-jamsostek') }} ",
                type: "POST",
                dataType: "json",
                data: {
                    year: salary_year
                },
                success: function(res) {
                    let rows = res;
                    generate_chart_payroll('chartDuesBPJSKetenagakerjaan', 'BPJS Ketenagakerjaan',
                        '#DC0091', rows);
                    generate_table('tableBodyDuesBPJSKetenagakerjaan', rows);
                }
            })
        }

        let func_chart_data_bpjs = (salary_year) => {

            $.ajax({
                url: "{{ route('api.payroll-report.data-bpjs') }} ",
                type: "POST",
                dataType: "json",
                data: {
                    year: salary_year
                },
                success: function(res) {
                    let rows = res;
                    generate_chart_payroll('chartDuesBPJSKesehatan', 'BPJS Kesehatan', '#DC0091', rows)
                    generate_table('tableBodyDuesBPJSKesehatan', rows);
                }
            })
        }

        let func_chart_data_pph21 = (salary_year) => {
            if (myChart != null) {
                myChart.destroy();
            }
            $.ajax({
                url: "{{ route('api.payroll-report.data-pph21') }} ",
                type: "POST",
                dataType: "json",
                data: {
                    year: salary_year
                },
                success: function(res) {
                    let rows = res;
                    generate_chart_payroll('chartDuesPPH21', 'BPJS PPH21', '#DC0091', rows)
                }
            })
        }

        $(document).on("keypress", "#salary_year", function(event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                let year = $(this).val();
                console.log(year);
            }

        })
    </script>

@stop
