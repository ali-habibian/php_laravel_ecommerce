@extends('admin.layouts.admin-layout')

@section('title', 'ادمین داشبورد')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"> داشبورد </h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i>
            گزارش
        </a>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-right-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"> لورم ایپسوم</div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">
                                40,000
                                تومان
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-right-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1"> لورم ایپسوم</div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">
                                215,000
                                تومان
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-right-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1"> وظایف</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 ml-3 font-weight-bold text-gray-800">50%</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm ml-2">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 50%"
                                             aria-valuenow="50"
                                             aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-right-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1"> کامنت ها</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->

    <div class="row">

        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary"> تراکنش‌های یک سال اخیر </h6>
{{--                    <div class="dropdown no-arrow">--}}
{{--                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"--}}
{{--                           aria-haspopup="true" aria-expanded="false">--}}
{{--                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>--}}
{{--                        </a>--}}
{{--                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in text-right"--}}
{{--                             aria-labelledby="dropdownMenuLink">--}}
{{--                            <div class="dropdown-header"> لورم ایپسوم :</div>--}}
{{--                            <a class="dropdown-item" href="#"> لورم </a>--}}
{{--                            <a class="dropdown-item" href="#"> لورم ایپسوم </a>--}}
{{--                            <div class="dropdown-divider"></div>--}}
{{--                            <a class="dropdown-item" href="#"> لورم ایپسوم متن ساختگی </a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="myAreaChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary"> تعداد تراکنش‌های یک سال اخیر </h6>
{{--                    <div class="dropdown no-arrow">--}}
{{--                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"--}}
{{--                           aria-haspopup="true" aria-expanded="false">--}}
{{--                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>--}}
{{--                        </a>--}}
{{--                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in text-right"--}}
{{--                             aria-labelledby="dropdownMenuLink">--}}
{{--                            <div class="dropdown-header"> لورم ایپسوم :</div>--}}
{{--                            <a class="dropdown-item" href="#"> لورم </a>--}}
{{--                            <a class="dropdown-item" href="#"> لورم ایپسوم </a>--}}
{{--                            <div class="dropdown-divider"></div>--}}
{{--                            <a class="dropdown-item" href="#"> لورم ایپسوم متن ساختگی </a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="myPieChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                    <span class="mr-2">
                        <i class="fas fa-circle text-success"></i> تراکنش موفق
                    </span>
                    <span class="mr-2">
                        <i class="fas fa-circle text-danger"></i> تراکنش ناموفق
                    </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Content Column -->
        <div class="col-lg-6 mb-4">

            <!-- Project Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"> پروژه ها </h6>
                </div>
                <div class="card-body">
                    <h4 class="small font-weight-bold"> HTML <span class="float-left">20%</span>
                    </h4>
                    <div class="progress mb-4">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 20%" aria-valuenow="20"
                             aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <h4 class="small font-weight-bold">CSS <span class="float-left">40%</span></h4>
                    <div class="progress mb-4">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 40%" aria-valuenow="40"
                             aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <h4 class="small font-weight-bold">Bootstrap <span class="float-left">60%</span></h4>
                    <div class="progress mb-4">
                        <div class="progress-bar" role="progressbar" style="width: 60%" aria-valuenow="60"
                             aria-valuemin="0"
                             aria-valuemax="100"></div>
                    </div>
                    <h4 class="small font-weight-bold">PHP <span class="float-left">80%</span></h4>
                    <div class="progress mb-4">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 80%" aria-valuenow="80"
                             aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <h4 class="small font-weight-bold">Laravel <span class="float-left">تمام!</span></h4>
                    <div class="progress">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100"
                             aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>

            <!-- Color System -->
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card bg-primary text-white shadow">
                        <div class="card-body">
                            Primary
                            <div class="text-white-50 small">#4e73df</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card bg-success text-white shadow">
                        <div class="card-body">
                            Success
                            <div class="text-white-50 small">#1cc88a</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card bg-info text-white shadow">
                        <div class="card-body">
                            Info
                            <div class="text-white-50 small">#36b9cc</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card bg-warning text-white shadow">
                        <div class="card-body">
                            Warning
                            <div class="text-white-50 small">#f6c23e</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card bg-danger text-white shadow">
                        <div class="card-body">
                            Danger
                            <div class="text-white-50 small">#e74a3b</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card bg-secondary text-white shadow">
                        <div class="card-body">
                            Secondary
                            <div class="text-white-50 small">#858796</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card bg-light text-black shadow">
                        <div class="card-body">
                            Light
                            <div class="text-black-50 small">#f8f9fc</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card bg-dark text-white shadow">
                        <div class="card-body">
                            Dark
                            <div class="text-white-50 small">#5a5c69</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-lg-6 mb-4">

            <!-- Illustrations -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">لورم ایپسوم</h6>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;"
                             src="img/undraw_posting_photo.svg" alt="">
                    </div>
                    <p>
                        لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.
                        چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی
                        تکنولوژی </p>

                </div>
            </div>

            <!-- Approach -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"> لورم ایپسوم </h6>
                </div>
                <div class="card-body">
                    <p>
                        لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.
                        چاپگرها
                        و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی
                    </p>
                    <p class="mb-0">
                        لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.
                        چاپگرها
                        و متون بلکه روزنامه و مجله در ستون
                    </p>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    {{-- Area Chart Demo --}}
    <script type="module">
        function toPersianDigits(num) {
            const persianDigits = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
            return num.toString().replace(/\d/g, d => persianDigits[d]);
        }

        function priceToPersianDigits(num) {
            const persianDigits = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
            const withCommas = Number(num).toLocaleString('en-US'); // adds comma separators
            return withCommas.replace(/\d/g, d => persianDigits[d]);
        }

        // Area Chart Example
        const ctx = document.getElementById("myAreaChart");
        const successTransactionsLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($monthNames),
                datasets: [
                    {
                        label: "تراکنش‌های موفق",
                        lineTension: 0.3,
                        backgroundColor: "rgba(78, 115, 223, 0.05)",
                        borderColor: "rgba(78, 115, 223, 1)",
                        pointRadius: 3,
                        pointBackgroundColor: "rgba(78, 115, 223, 1)",
                        pointBorderColor: "rgba(78, 115, 223, 1)",
                        pointHoverRadius: 3,
                        pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                        pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                        pointHitRadius: 10,
                        pointBorderWidth: 2,
                        data: @json($successTransactions),
                    },
                    {
                        label: "تراکنش‌های ناموفق",
                        lineTension: 0.3,
                        backgroundColor: "rgba(78, 115, 223, 0.05)",
                        borderColor: "rgb(234,46,81)",
                        pointRadius: 3,
                        pointBackgroundColor: "rgb(234,46,81)",
                        pointBorderColor: "rgb(234,46,81)",
                        pointHoverRadius: 3,
                        pointHoverBackgroundColor: "rgb(234,46,81)",
                        pointHoverBorderColor: "rgb(234,46,81)",
                        pointHitRadius: 10,
                        pointBorderWidth: 2,
                        data: @json($failedTransactions),
                    }
                ],
            },
            options: {
                maintainAspectRatio: false,
                layout: {
                    padding: 10
                },
                scales: {
                    y: {
                        ticks: {
                            callback: function(value) {
                                return priceToPersianDigits(value) + ' تومان';
                            }
                        }
                    },
                    x: {
                        ticks: {
                            callback: function(value, index, ticks) {
                                return toPersianDigits(this.getLabelForValue(value));
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        bodyFont: {
                            family: 'Tahoma',
                            size: 13
                        },
                        callbacks: {
                            label: function(context) {
                                const label = context.dataset.label || '';
                                const value = priceToPersianDigits(context.parsed.y) + ' تومان ';
                                return label + ': ' + value;
                            }
                        }
                    },
                    legend: {
                        labels: {
                            font: {
                                family: 'Tahoma',
                                size: 13
                            }
                        }
                    }
                }
            }
        });

        // Pie Chart Example
        const ctxPie = document.getElementById("myPieChart");
        const myPieChart = new Chart(ctxPie, {
            type: 'doughnut',
            data: {
                labels: ["تراکنش موفق", "تراکنش ناموفق"],
                datasets: [{
                    data: @json($transactionsCount),
                    backgroundColor: ['#1cc88a', '#ea2e51'],
                    hoverBackgroundColor: ['#127855', '#97152d'],
                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                }],
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        bodyFont: {
                            family: 'Tahoma',
                            size: 14,
                            // weight: 'bold'
                        },
                        callbacks: {
                            label: function(context) {
                                const value = toPersianDigits(context.parsed);
                                return ' ' + value + ' عدد ';
                            }
                        }
                    }
                }
            },
        });
    </script>
@endpush
