@extends('admin.components.master')
@section('title', 'DASHBOARD')

@section('container')
    <div class="page-heading">
        <h3>Dashboard</h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">

                <div class="row">
                    <div class="col-12 col-xl-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Grafik Penjualan</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div id="chart-order"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Data Penjualan Product</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-lg">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Price</th>
                                                <th>Order</th>
                                                <th>Stok</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="col-3">
                                                    <div class="d-flex align-items-center">
                                                        <p class="font-bold ms-3 mb-0"></p>
                                                    </div>
                                                </td>
                                                <td class="col-auto">
                                                    <p class="mb-0">

                                                    </p>
                                                </td>
                                                <td>
                                                    <div class="col-auto">
                                                        <p class="mb-0"></p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="col-auto">
                                                        <p class="mb-0"></p>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @push('scripts')
                <script src="{{ asset('assets/extensions/apexcharts/apexcharts.min.js') }}"></script>
                {{-- <script src="{{ asset('assets/js/pages/dashboard.js') }}"></script> --}}
                <script>
                    var areaOptions = {
                        series: [{
                                name: "Order",
                                data: ,
                            },
                            // {
                            //     name: "series2",
                            //     data: [11, 32, 45, 32, 34, 52, 41],
                            // },
                        ],
                        chart: {
                            height: 350,
                            type: "area",
                        },
                        dataLabels: {
                            enabled: false,
                        },
                        stroke: {
                            curve: "smooth",
                        },
                        xaxis: {
                            type: "datetime",
                            categories: ,
                        },
                        tooltip: {
                            x: {
                                format: "dd/MM/yy HH:mm",
                            },
                        },
                    };

                    var area = new ApexCharts(document.querySelector("#chart-order"), areaOptions);

                    area.render();
                </script>
            @endpush
        </section>
    </div>
@endsection
