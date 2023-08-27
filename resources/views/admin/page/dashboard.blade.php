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
                                <h4>Grafik Peminjaman</h4>
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
                                <h4>Data Peminjaman Buku</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-lg">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Buku</th>
                                                <th>Siswa</th>
                                                <th>Tanggal Pinjam</th>
                                                <th>Tanggal Kembali</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data_list as $item)
                                                <tr>
                                                    <td class="col-3">
                                                        <div class="d-flex align-items-center">
                                                            <p class="font-bold ms-3 mb-0">{{ $loop->iteration }}</p>
                                                        </div>
                                                    </td>
                                                    <td class="col-auto">
                                                        <p class="mb-0">
                                                            {{ $item->Buku[0]->judul }}
                                                        </p>
                                                    </td>
                                                    <td>
                                                        <div class="col-auto">
                                                            <p class="mb-0">{{ $item->User[0]->username }}</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="col-auto">
                                                            <p class="mb-0">{{ $item->Peminjaman[0]->tgl_pinjam }}</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="col-auto">
                                                            <p class="mb-0">{{ $item->Peminjaman[0]->tgl_kembali }}</p>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
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
                            data: {!! json_encode($peminjaman_grafik) !!},
                        }, ],
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
                            categories: {!! json_encode($bulan_grafik) !!},
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
