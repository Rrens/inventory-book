@extends('admin.components.master')
@section('title', 'PEMINJAMAN')
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
            <h3>Peminjaman Control</h3>
        </div>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <div class="flex-start">
                                    <p>Book Table</p>
                                </div>
                                <div class="flex-end">
                                    <button class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#modalTambahPeminjaman">Peminjaman</button>
                                    <button class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#modalTambahPengembalian">Pengembalian</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped" id="table1">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Judul Buku</th>
                                            <th>Nama Member</th>
                                            <th>Tanggal Pinjam</th>
                                            <th>Tanggal Kembali</th>
                                            <th>Keterangan</th>
                                            <th>Aksi</th>
                                            <th>Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            // dd($data);
                                        @endphp
                                        @foreach ($data as $item)
                                            <tr>
                                                <td class="text-bold-500">
                                                    {{ $item->id }}
                                                </td>
                                                <td class="text-bold-500">
                                                    {{ $item->Buku[0]->judul }}
                                                </td>
                                                <td class="text-bold-500">
                                                    {{ $item->User[0]->username }}
                                                </td>
                                                <td class="text-bold-500">
                                                    {{ $item->Peminjaman[0]->tgl_pinjam }}
                                                </td>
                                                <td class="text-bold-500">
                                                    {{ $item->Peminjaman[0]->tgl_kembali }}
                                                </td>
                                                <td class="text-bold-500">
                                                    {{ $item->keterangan == 'pinjam' ? 'Masih Dipinjam' : 'Sudah Dibalikin' }}
                                                </td>
                                                <td>
                                                    <a class="tagA btn btn-outline-warning" href="#"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalEditPeminjaman{{ $item->id }}">
                                                        <i class="bi bi-pencil-fill"></i>
                                                    </a>
                                                    <a class="tagA btn btn-outline-danger" href="#"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalDeletePeminjaman{{ $item->id }}">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a class="tagA btn btn-primary" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#modalDetailPeminjaman{{ $item->id }}"><i
                                                            class="bi bi-exclamation-triangle-fill"></i>
                                                    </a>
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

    <div class="modal fade" id="modalTambahPeminjaman" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-center">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Peminjaman</h5>
                </div>
                <form action="{{ route('admin.peminjaman.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="d-flex justify-content-between">
                            <div class="flex-start">
                                <div class="form-group mb-3">
                                    <label for="basicInput">ID Member</label>
                                    <input type="number" class="form-control mt-3" round id="id_member" name="id_member"
                                        value="{{ old('id_member') }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Nama Member</label>
                                    <input type="text" class="form-control mt-3" round id="nama_member"
                                        name="nama_member" value="{{ old('nama_member') }}" required readonly>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Tipe Member</label>
                                    <input type="text" class="form-control mt-3" round id="member_type"
                                        name="member_type" value="{{ old('member_type') }}" required readonly>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Riwayat Jumlah Pinjam</label>
                                    <input type="text" class="form-control mt-3" round id="jumlah_pinjam"
                                        name="riwayat_pinjam" value="{{ old('riwayat_pinjam') }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Jumlah buku belum kembali</label>
                                    <input type="text" class="form-control mt-3" round id="jumlah_pinjam_belum_kembali"
                                        name="buku_belum_kembali" value="{{ old('buku_belum_kembali') }}">
                                </div>
                            </div>
                            <div class="flex-end">
                                <div class="form-group mb-3">
                                    <label for="basicInput">ISBN</label>
                                    <input type="text" class="form-control mt-3" round id="isbn" name="isbn"
                                        value="{{ old('deskripsi_fisik') }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Judul Buku</label>
                                    <input type="text" class="form-control mt-3" round id="judul_buku"
                                        name="judul_buku" value="{{ old('judul_buku') }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Tanggal Pinjam</label>
                                    <input type="date" class="form-control mt-3" round id="tanggal_kembali"
                                        name="tanggal_pinjam" value="{{ $date }}" required readonly>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Tanggal Kembali</label>
                                    <input type="date" class="form-control mt-3" round id="basicInput"
                                        name="tanggal_kembali" value="{{ old('tanggal_kembali') }}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Batal</span>
                        </button>
                        <button type="submit" class="btn btn-primary ml-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Simpan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalTambahPengembalian" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-center">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Pengembalian</h5>
                </div>
                <form action="{{ route('admin.pengembalian.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="d-flex justify-content-between">
                            <div class="flex-start">
                                <div class="form-group mb-3">
                                    <label for="basicInput">Nama Member *</label>
                                    <input type="text" class="form-control mt-3" round id="member_name"
                                        name="member_name" value="{{ old('member_name') }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Jumlah Buku dipinjam</label>
                                    <input type="text" class="form-control mt-3" round id="jumlah_buku_pinjam"
                                        name="jumlah_buku_pinjam" value="{{ old('jumlah_buku_pinjam') }}" required
                                        readonly>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Tanggal Pinjam</label>
                                    <input type="gi " class="form-control mt-3" round id="tgl_pinjam"
                                        name="tgl_pinjam" value="{{ old('tgl_pinjam') }}" required readonly>
                                </div>
                            </div>
                            <div class="flex-end">
                                <div class="form-group mb-3">
                                    <label for="basicInput">ISBN</label>
                                    <input type="text" class="form-control mt-3" round id="isbn_pengembalian"
                                        name="isbn" value="{{ old('isbn') }}" readonly required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Judul Buku</label>
                                    <input type="text" class="form-control mt-3" round id="judul"
                                        name="judul_buku" required readonly>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Tanggal Kembali</label>
                                    <input type="text" class="form-control mt-3" round id="tgl_kembali"
                                        name="tgl_kembali" value="{{ old('tgl_kembali') }}" required readonly>
                                    <input type="date" id="tanggal_pengembalian" name="tgl_pengembalian"
                                        value="{{ $date }}" hidden readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Batal</span>
                        </button>
                        <button type="submit" class="btn btn-primary ml-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Simpan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{-- MODAL EDIT --}}
    @foreach ($data as $item)
        @php
            // dd($item);
        @endphp
        <div class="modal fade" id="modalEditPeminjaman{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-center">
                        <h5 class="modal-title" id="exampleModalScrollableTitle">Edit Peminjaman
                        </h5>
                    </div>
                    <form action="{{ route('admin.peminjaman.update') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="d-flex justify-content-between">
                                <div class="flex-start">
                                    <div class="form-group mb-3">
                                        <label for="basicInput">ID Member</label>
                                        <input type="number" class="form-control mt-3" round id="id_member_edit"
                                            name="id_member" value="{{ $item->User[0]->id }}" required>
                                        <input type="text" name="id_peminjaman"
                                            value="{{ $item->Peminjaman[0]->id }}" hidden>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="basicInput">Nama Member</label>
                                        <input type="text" class="form-control mt-3" round id="nama_member_edit"
                                            name="nama_member" value="{{ $item->User[0]->username }}" readonly>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="basicInput">Tipe Member</label>
                                        <input type="text" class="form-control mt-3" round id="member_type_edit"
                                            name="member_type"
                                            value="{{ $item->User[0]->type_anggota == null ? 'Admin' : $item->User[0]->type_anggota }}"
                                            readonly>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="basicInput">Riwayat Jumlah Pinjam</label>
                                        <input type="text" class="form-control mt-3" round id="jumlah_pinjam_edit"
                                            name="riwayat_pinjam"
                                            value="{{ $detail_riwayat->where('id_user', $item->User[0]->id)->count('id_user') }}"
                                            readonly>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="basicInput">Jumlah buku belum kembali</label>
                                        <input type="text" class="form-control mt-3" round
                                            id="jumlah_pinjam_belum_kembali_edit" name="buku_belum_kembali"
                                            value="{{ $detail_riwayat->where('id_user', $item->User[0]->id)->where('keterangan', 'pinjam')->count('id_user') }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="flex-end">
                                    <div class="form-group mb-3">
                                        <label for="basicInput">ISBN</label>
                                        <input type="text" class="form-control mt-3" round id="isbn_edit"
                                            name="isbn" value="{{ $item->Buku[0]->isbn }}" required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="basicInput">Judul Buku</label>
                                        <input type="text" class="form-control mt-3" round id="judul_buku_edit"
                                            name="judul_buku" value="{{ $item->Buku[0]->judul }}" readonly>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="basicInput">Tanggal Pinjam</label>
                                        <input type="date" class="form-control mt-3" round id="tanggal_kembali_edit"
                                            name="tanggal_pinjam" value="{{ $item->Peminjaman[0]->tgl_pinjam }}"
                                            readonly>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="basicInput">Tanggal Kembali</label>
                                        <input type="date" class="form-control mt-3" round id="basicInput"
                                            name="tanggal_kembali" value="{{ $item->Peminjaman[0]->tgl_kembali }}"
                                            required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Batal</span>
                            </button>
                            <button type="submit" class="btn btn-primary ml-1" data-bs-dismiss="modal">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <input name="id" value="" hidden>
                                <span class="d-none d-sm-block">Simpan</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    {{-- MODAL DELETE --}}
    @foreach ($data as $item)
        <div class="modal fade" id="modalDeletePeminjaman{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-center">
                        <h5 class="modal-title" id="exampleModalScrollableTitle">Hapus
                        </h5>
                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Batal</span>
                        </button>
                        <form action="{{ route('admin.peminjaman.delete') }}" method="post">
                            @csrf
                            <input name="id_peminjaman" value="{{ $item->id_peminjaman }}" hidden>
                            <button type="submit" class="btn btn-danger ml-1" data-bs-dismiss="modal">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Hapus</span>
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    @endforeach

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
                        <div class="d-flex justify-content-between">
                            <div class="flex-start">
                                <div class="form-group mb-3">
                                    <label for="basicInput">ID Member</label>
                                    <input type="number" class="form-control mt-3" round id="id_member"
                                        name="id_member" value="{{ $item->User[0]->id }}" readonly>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Nama Member</label>
                                    <input type="text" class="form-control mt-3" round id="nama_member"
                                        name="nama_member" value="{{ $item->User[0]->username }}" readonly>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Tipe Member</label>
                                    <input type="text" class="form-control mt-3" round id="member_type"
                                        name="member_type"
                                        value="{{ $item->User[0]->type_anggota == null ? 'Admin' : $item->User[0]->type_anggota }}"
                                        readonly>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Riwayat Jumlah Pinjam</label>
                                    <input type="text" class="form-control mt-3" round id="jumlah_pinjam"
                                        name="riwayat_pinjam"
                                        value="{{ $detail_riwayat->where('id_user', $item->User[0]->id)->count('id_user') }}"
                                        readonly>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Jumlah buku belum kembali</label>
                                    <input type="text" class="form-control mt-3" round
                                        id="jumlah_pinjam_belum_kembali" name="buku_belum_kembali"
                                        value="{{ $detail_riwayat->where('id_user', $item->User[0]->id)->where('keterangan', 'pinjam')->count('id_user') }}"
                                        readonly>
                                </div>
                            </div>
                            <div class="flex-end">
                                <div class="form-group mb-3">
                                    <label for="basicInput">ISBN</label>
                                    <input type="text" class="form-control mt-3" round id="isbn" name="isbn"
                                        value="{{ $item->Buku[0]->isbn }}" readonly>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Judul Buku</label>
                                    <input type="text" class="form-control mt-3" round id="judul_buku"
                                        name="judul_buku" value="{{ $item->Buku[0]->judul }}" readonly>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Tanggal Pinjam</label>
                                    <input type="date" class="form-control mt-3" round id="tanggal_kembali"
                                        name="tanggal_pinjam" value="{{ $item->Peminjaman[0]->tgl_pinjam }}" readonly>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Tanggal Kembali</label>
                                    <input type="date" class="form-control mt-3" round id="basicInput"
                                        name="tanggal_kembali" value="{{ $item->Peminjaman[0]->tgl_kembali }}" readonly>
                                </div>
                            </div>
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

    @include('admin.scripts.peminjaman')

    <script src="{{ asset('assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/js/pages/simple-datatables.js') }}"></script>
@endpush
