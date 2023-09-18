@extends('admin.components.master')
@section('title', 'LAPORAN')
@push('head')
    <style>
        .color-card {
            background-color: rgb(14, 12, 27);
        }

        .img-container {
            /* position: relative; */
            /* padding-top: 100%; */
        }

        img {
            max-width: 500px;
        }

        body.theme-dark a {
            /* text-decoration: none !important;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    color: white; */
            color: inherit;
            text-decoration: none !important;
        }
    </style>
    <style>
        .cards-wrapper {
            display: flex;
            justify-content: center;
        }

        .card img {
            max-width: 100%;
            max-height: 100%;
        }

        .card {
            margin: 0 0.5em;
            box-shadow: 2px 6px 8px 0 rgba(22, 22, 26, 0.18);
            border: none;
            border-radius: 0;
        }

        .carousel-inner {
            padding: 1em;
        }

        .carousel-control-prev,
        .carousel-control-next {
            background-color: #e1e1e1;
            width: 5vh;
            height: 5vh;
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
        }

        @media (min-width: 768px) {
            .card img {
                height: 11em;
            }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('assets/extensions/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/simple-datatables.css') }}">
@endpush

@section('container')
    <div class="page-heading d-flex justify-content-between">
        <div class="flex-start">
            <h3>Laporan Control</h3>
        </div>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <h6 class="text-muted font-semibold">
                                        Total transaksi peminjaman
                                    </h6>
                                    <h6 class="font-extrabold mb-0">
                                        {{ $for_count->where('keterangan', 'kembali')->count() }}
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <h6 class="text-muted font-semibold">
                                        Buku terlambat
                                    </h6>
                                    <h6 class="font-extrabold mb-0">{{ $for_count->where('keterangan', 'Telat')->count() }}
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <h6 class="text-muted font-semibold">
                                        Buku dipinjam
                                    </h6>
                                    <h6 class="font-extrabold mb-0">{{ $for_count->where('keterangan', 'pinjam')->count() }}
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <div class="flex-start">
                                    <a href="#" class="btn btn-outline-success">Print</a>
                                </div>
                                <div class="flex-end">
                                    <form action="{{ route('admin.laporan.filter') }}" method="post">
                                        @csrf
                                        <input type="date" name="date" class="btn btn-primary">
                                        <button class="btn btn-primary" type="submit">Filter Tanggal</button>
                                    </form>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped" id="table1">
                                    <thead>
                                        <tr>
                                            <th>ID Peminjaman</th>
                                            <th>Tanggal</th>
                                            <th>Buku Dipinjam</th>
                                            <th>Buku Kembali</th>
                                            <th>Buku Terlambat</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td class="text-bold-500">
                                                    {{ $item->id_peminjaman }}
                                                </td>
                                                <td class="text-bold-500">
                                                    {{ $item->tgl_pinjam }}
                                                </td>
                                                <td class="text-bold-500">
                                                    {{ $for_count->where('tgl_pinjam', $item->tgl_pinjam)->where('keterangan', 'pinjam')->count() +$for_count->where('tgl_pinjam', $item->tgl_pinjam)->where('keterangan', 'Telat')->count() }}
                                                </td>
                                                <td class="text-bold-500">
                                                    {{ $for_count->where('tgl_pinjam', $item->tgl_pinjam)->where('keterangan', 'kembali')->count() }}
                                                </td>
                                                <td class="text-bold-500">
                                                    {{ $for_count->where('tgl_pinjam', $item->tgl_pinjam)->where('keterangan', 'Telat')->count() }}
                                                </td>
                                                <td>
                                                    <form action="{{ route('admin.laporan.print') }}" method="post">
                                                        @csrf
                                                        <a class="tagA btn btn-primary" href="#"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modalDetailPeminjaman{{ $item->id }}"><i
                                                                class="bi bi-info-lg"></i>
                                                        </a>
                                                        <input type="date" value="{{ $item->tgl_pinjam }}"
                                                            name="date" hidden>
                                                        <button class="tagA btn btn-success" type="submit"><i
                                                                class="bi bi-printer"></i>
                                                        </button>
                                                    </form>
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
        </section>
    </div>

    {{-- MODAL DETAIL --}}
    @foreach ($data as $item)
        <div class="modal fade" id="modalDetailPeminjaman{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-center">
                        <h5 class="modal-title" id="exampleModalScrollableTitle">Detail Peminjaman
                        </h5>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Peminjam</th>
                                        <th>ISBN</th>
                                        <th>Judul</th>
                                        <th>Tanggal Pinjam</th>
                                        <th>Tanggal Kembali</th>
                                        <th>Status Pinjam</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data_detail->where('tanggal', $item->tgl_pinjam) as $item)
                                        <tr>
                                            <td class="text-bold-500">
                                                {{ $loop->iteration }}
                                            </td>
                                            <td class="text-bold-500">
                                                {{ $item->User[0]->username }}
                                            </td>
                                            <td class="text-bold-500">
                                                {{ $item->Buku[0]->isbn }}
                                            </td>
                                            <td class="text-bold-500">
                                                {{ $item->Buku[0]->judul }}
                                            </td>
                                            <td class="text-bold-500">
                                                {{ $item->Peminjaman[0]->tgl_pinjam }}
                                            </td>
                                            <td class="text-bold-500">
                                                {{ $item->Peminjaman[0]->tgl_kembali }}
                                            </td>
                                            <td class="text-bold-500">
                                                <span
                                                    class="btn btn-{{ $item->keterangan == 'Telat' ? 'danger' : ($item->keterangan == 'pinjam' ? 'warning' : 'success') }}">{{ $item->keterangan == 'Telat' ? 'Terlambat' : ($item->keterangan == 'pinjam' ? 'Dipinjam' : 'Kembali') }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection

@push('scripts')
    <script src="{{ asset('assets/extensions/choices.js/public/assets/scripts/choices.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"
        integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <script src="{{ asset('assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/js/pages/simple-datatables.js') }}"></script>
@endpush
