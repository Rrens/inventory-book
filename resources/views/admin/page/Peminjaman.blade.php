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
                                        <td class="text-bold-500">
                                            1
                                        </td>
                                        <td class="text-bold-500">
                                            SANG SURYA DI LANGIT MAROKO
                                        </td>
                                        <td class="text-bold-500">
                                            Ahmad Juliansyah
                                        </td>
                                        <td class="text-bold-500">
                                            12 Mar 2021
                                        </td>
                                        <td class="text-bold-500">
                                            24 Mar 2021
                                        </td>
                                        <td class="text-bold-500">
                                            Sudah Dikembalikan
                                        </td>
                                        <td>
                                            <a class="tagA btn btn-outline-warning" href="#" data-bs-toggle="modal"
                                                data-bs-target="#modalEditPeminjaman">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                            <a class="tagA btn btn-outline-danger" href="#" data-bs-toggle="modal"
                                                data-bs-target="#modalDeletePeminjaman">
                                                <i class="bi bi-trash-fill"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a class="tagA btn btn-primary" href="#" data-bs-toggle="modal"
                                                data-bs-target="#modalDetailPeminjaman"><i
                                                    class="bi bi-exclamation-triangle-fill"></i>
                                            </a>
                                        </td>
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
                <form action="{{ route('admin.user.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="d-flex justify-content-between">
                            <div class="flex-start">
                                <div class="form-group mb-3">
                                    <label for="basicInput">Id Member</label>
                                    <input type="number" class="form-control mt-3" round id="basicInput" name="id_anggota"
                                        value="{{ old('id_anggota') }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Nama Member</label>
                                    <input type="text" class="form-control mt-3" round id="basicInput" name="nama_member"
                                        value="{{ old('nama_member') }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Tipe Member</label>
                                    <select class="form-select mt-3" name="member_type" required>
                                        <option selected hidden>Pilih Tipe Member</option>
                                        <option value="0">Guru
                                        </option>
                                        <option value="1">Siswa
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Riwayat Jumlah Pinjam</label>
                                    <input type="text" class="form-control mt-3" round id="basicInput"
                                        name="riwayat_pinjam" value="{{ old('riwayat_pinjam') }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Jumlah buku belum kembali</label>
                                    <input type="text" class="form-control mt-3" round id="basicInput"
                                        name="buku_belum_kembali" value="{{ old('buku_belum_kembali') }}" required>
                                </div>
                            </div>
                            <div class="flex-end">
                                <div class="form-group mb-3">
                                    <label for="basicInput">ISBN</label>
                                    <input type="text" class="form-control mt-3" round id="basicInput" name="isbn"
                                        value="{{ old('deskripsi_fisik') }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Judul Buku</label>
                                    <input type="text" class="form-control mt-3" round id="basicInput"
                                        name="judul_buku" value="{{ old('judul_buku') }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Tanggal Pinjam</label>
                                    <input type="date" class="form-control mt-3" round id="basicInput"
                                        name="tanggal_pinjam" value="{{ old('tanggal_pinjam') }}" required>
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
                <form action="{{ route('admin.user.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="d-flex justify-content-between">
                            <div class="flex-start">
                                <div class="form-group mb-3">
                                    <label for="basicInput">Nama Member *</label>
                                    <input type="text" class="form-control mt-3" round id="basicInput"
                                        name="member_name" value="{{ old('member_name') }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Jumlah Buku dipinjam *</label>
                                    <input type="text" class="form-control mt-3" round id="basicInput"
                                        name="jumlah_buku_pinjam" value="{{ old('jumlah_buku_pinjam') }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">ISBN</label>
                                    <input type="text" class="form-control mt-3" round id="basicInput" name="isbn"
                                        value="{{ old('isbn') }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Judul Buku</label>
                                    <input type="text" class="form-control mt-3" round id="basicInput"
                                        name="judul_buku" value="{{ old('judul_buku') }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Tanggal Pinjam</label>
                                    <input type="gi " class="form-control mt-3" round id="basicInput"
                                        name="tanggal_pinjam" value="{{ old('tanggal_pinjam') }}" required>
                                </div>
                            </div>
                            <div class="flex-end">
                                <div class="form-group mb-3">
                                    <label for="basicInput">Tanggal Kembali</label>
                                    <input type="text" class="form-control mt-3" round id="basicInput"
                                        name="tanggal_kembali" value="{{ old('tanggal_kembali') }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Denda</label>
                                    <input type="text" class="form-control mt-3" round id="basicInput" name="denda"
                                        value="{{ old('denda') }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Tanggal Pinjam</label>
                                    <input type="date" class="form-control mt-3" round id="basicInput"
                                        name="tanggal_pinjam" value="{{ old('tanggal_pinjam') }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Tanggal Kembali</label>
                                    <input type="date" class="form-control mt-3" round id="basicInput"
                                        name="tanggal_kembali" value="{{ old('tanggal_kembali') }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Denda</label>
                                    <input type="number" class="form-control mt-3" round id="basicInput" name="denda"
                                        value="{{ old('denda') }}">
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
    {{-- @foreach ($data as $item) --}}
    <div class="modal fade" id="modalEditPeminjaman" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-center">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Edit Peminjaman
                    </h5>
                </div>
                <form action="{{ route('admin.user.update') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="d-flex justify-content-between">
                            <div class="flex-start">
                                <div class="form-group mb-3">
                                    <label for="basicInput">ISBN *</label>
                                    <input type="text" class="form-control mt-3" round id="basicInput" name="isbn"
                                        value="{{ old('isbn') }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Judul *</label>
                                    <input type="text" class="form-control mt-3" round id="basicInput" name="judul"
                                        value="{{ old('judul') }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">GMD</label>
                                    <input type="text" class="form-control mt-3" round id="basicInput" name="gmd"
                                        value="{{ old('gmd') }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Edisi</label>
                                    <input type="text" class="form-control mt-3" round id="basicInput" name="edisi"
                                        value="{{ old('edisi') }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Penerbit</label>
                                    <input type="text" class="form-control mt-3" round id="basicInput"
                                        name="penerbit" value="{{ old('penerbit') }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Tahun Terbit *</label>
                                    <input type="tel" min="1900" max="2099" maxlength="4"
                                        class="form-control mt-3" round id="basicInput" name="tahun_terbit"
                                        value="{{ old('tahun_terbit') }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Tempat Penerbit</label>
                                    <input type="text" class="form-control mt-3" round id="basicInput"
                                        name="tempat_penerbit" value="{{ old('tempat_penerbit') }}">
                                </div>
                            </div>
                            <div class="flex-end">
                                <div class="form-group mb-3">
                                    <label for="basicInput">Deskripsi Fisik</label>
                                    <input type="text" class="form-control mt-3" round id="basicInput"
                                        name="deskripsi_fisik" value="{{ old('deskripsi_fisik') }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Judul Seri</label>
                                    <input type="text" class="form-control mt-3" round id="basicInput"
                                        name="judul_seri" value="{{ old('judul_seri') }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Nomor Panggilan</label>
                                    <input type="number" class="form-control mt-3" round id="basicInput"
                                        name="nomor_panggilan" value="{{ old('nomor_panggilan') }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Bahasa</label>
                                    <input type="text" class="form-control mt-3" round id="basicInput" name="bahasa"
                                        value="{{ old('bahasa') }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">No Klas</label>
                                    <input type="number" class="form-control mt-3" round id="basicInput" name="no_klas"
                                        value="{{ old('no_klas') }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Pengarang</label>
                                    <input type="text" class="form-control mt-3" round id="basicInput" name="bahasa"
                                        value="{{ old('bahasa') }}" required>
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
    {{-- @endforeach --}}

    {{-- MODAL DELETE --}}
    {{-- @foreach ($data as $item) --}}
    <div class="modal fade" id="modalDeletePeminjaman" tabindex="-1" role="dialog"
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
                    <form action="{{ route('admin.user.delete') }}" method="post">
                        @csrf
                        <input name="id" value="" hidden>
                        <button type="submit" class="btn btn-danger ml-1" data-bs-dismiss="modal">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Hapus</span>
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    {{-- @endforeach --}}

    {{-- MODAL DETAIL --}}
    {{-- @foreach ($data as $item) --}}
    <div class="modal fade" id="modalDetailPeminjaman" tabindex="-1" role="dialog"
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
                                <label for="basicInput">ISBN *</label>
                                <input type="text" class="form-control mt-3" round id="basicInput" name="isbn"
                                    value="{{ old('isbn') }}" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="basicInput">Judul *</label>
                                <input type="text" class="form-control mt-3" round id="basicInput" name="judul"
                                    value="{{ old('judul') }}" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="basicInput">GMD</label>
                                <input type="text" class="form-control mt-3" round id="basicInput" name="gmd"
                                    value="{{ old('gmd') }}">
                            </div>
                            <div class="form-group mb-3">
                                <label for="basicInput">Edisi</label>
                                <input type="text" class="form-control mt-3" round id="basicInput" name="edisi"
                                    value="{{ old('edisi') }}" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="basicInput">Penerbit</label>
                                <input type="text" class="form-control mt-3" round id="basicInput" name="penerbit"
                                    value="{{ old('penerbit') }}" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="basicInput">Tahun Terbit *</label>
                                <input type="tel" min="1900" max="2099" maxlength="4"
                                    class="form-control mt-3" round id="basicInput" name="tahun_terbit"
                                    value="{{ old('tahun_terbit') }}" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="basicInput">Tempat Penerbit</label>
                                <input type="text" class="form-control mt-3" round id="basicInput"
                                    name="tempat_penerbit" value="{{ old('tempat_penerbit') }}">
                            </div>
                        </div>
                        <div class="flex-end">
                            <div class="form-group mb-3">
                                <label for="basicInput">Deskripsi Fisik</label>
                                <input type="text" class="form-control mt-3" round id="basicInput"
                                    name="deskripsi_fisik" value="{{ old('deskripsi_fisik') }}" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="basicInput">Judul Seri</label>
                                <input type="text" class="form-control mt-3" round id="basicInput" name="judul_seri"
                                    value="{{ old('judul_seri') }}">
                            </div>
                            <div class="form-group mb-3">
                                <label for="basicInput">Nomor Panggilan</label>
                                <input type="number" class="form-control mt-3" round id="basicInput"
                                    name="nomor_panggilan" value="{{ old('nomor_panggilan') }}" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="basicInput">Bahasa</label>
                                <input type="text" class="form-control mt-3" round id="basicInput" name="bahasa"
                                    value="{{ old('bahasa') }}" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="basicInput">No Klas</label>
                                <input type="number" class="form-control mt-3" round id="basicInput" name="no_klas"
                                    value="{{ old('no_klas') }}" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="basicInput">Pengarang</label>
                                <input type="text" class="form-control mt-3" round id="basicInput" name="bahasa"
                                    value="{{ old('bahasa') }}" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success ml-1" data-bs-dismiss="modal">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Tutup</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{-- @endforeach --}}

@endsection

@push('scripts')
    <script src="{{ asset('assets/extensions/choices.js/public/assets/scripts/choices.js') }}"></script>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>

    @include('admin.scripts.index-user')

    <script src="{{ asset('assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/js/pages/simple-datatables.js') }}"></script>
@endpush
