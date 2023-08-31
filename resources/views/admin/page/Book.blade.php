@extends('admin.components.master')
@section('title', 'BUKU')
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
            <h3>Buku Control</h3>
        </div>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <p>Book Table</p>
                                <button class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#modalTambahBuku">Tambah</button>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped" id="table1">
                                    <thead>
                                        <tr>
                                            <th>ISBN</th>
                                            <th>Judul Buku</th>
                                            <th>Penerbit</th>
                                            <th>Tahun Terbit</th>
                                            <th>Pengarang</th>
                                            <th>Keterangan</th>
                                            <th>Aksi</th>
                                            <th>Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td class="text-bold-500">
                                                    {{ $item->isbn }}
                                                </td>
                                                <td class="text-bold-500">
                                                    {{ $item->judul }}
                                                </td>
                                                <td class="text-bold-500">
                                                    {{ $item->penerbit }}
                                                </td>
                                                <td class="text-bold-500">
                                                    {{ $item->tahun_terbit }}
                                                </td>
                                                <td class="text-bold-500">
                                                    {{ $item->pengarang }}
                                                </td>
                                                <td class="text-bold-500">
                                                    {{ $item->keterangan == 'pinjam' ? 'Tidak tersedia' : 'Tersedia' }}
                                                </td>
                                                <td>
                                                    <a class="tagA btn btn-outline-warning" href="#"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalEditBuku{{ $item->id }}">
                                                        <i class="bi bi-pencil-fill"></i>
                                                    </a>
                                                    <a class="tagA btn btn-outline-danger" href="#"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalDeleteBuku{{ $item->id }}">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a class="tagA btn btn-primary" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#modalDetailBuku{{ $item->id }}"><i
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

    {{-- MODAL TAMBAH --}}
    <div class="modal fade" id="modalTambahBuku" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-center">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Tambah Buku</h5>
                </div>
                <form action="{{ route('admin.book.store') }}" method="post" enctype="multipart/form-data">
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
                                    <input type="text" class="form-control mt-3" round id="basicInput"
                                        name="judul_seri" value="{{ old('judul_seri') }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Nomor Panggilan</label>
                                    <input type="number" class="form-control mt-3" round id="basicInput"
                                        name="nomor_panggilan" value="{{ old('nomor_panggilan') }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Bahasa</label>
                                    <input type="text" class="form-control mt-3" round id="basicInput" name="bahasa"
                                        value="{{ old('bahasa') }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">No Klas</label>
                                    <input type="number" class="form-control mt-3" round id="basicInput" name="no_klas"
                                        value="{{ old('no_klas') }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Pengarang</label>
                                    <input type="text" class="form-control mt-3" round id="basicInput"
                                        name="pengarang" value="{{ old('pengarang') }}" required>
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
        <div class="modal fade" id="modalEditBuku{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-center">
                        <h5 class="modal-title" id="exampleModalScrollableTitle">Edit Buku {{ $item->judul }}
                        </h5>
                    </div>
                    <form action="{{ route('admin.book.update') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="d-flex justify-content-between">
                                <div class="flex-start">
                                    <div class="form-group mb-3">
                                        <label for="basicInput">ISBN *</label>
                                        <input type="text" class="form-control mt-3" round id="basicInput"
                                            name="isbn" value="{{ empty($item->isbn) ? '' : $item->isbn }}" required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="basicInput">Judul *</label>
                                        <input type="text" class="form-control mt-3" round id="basicInput"
                                            name="judul" value="{{ empty($item->judul) ? '' : $item->judul }}"
                                            required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="basicInput">GMD</label>
                                        <input type="text" class="form-control mt-3" round id="basicInput"
                                            name="gmd" value="{{ empty($item->gmd) ? '' : $item->gmd }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="basicInput">Edisi</label>
                                        <input type="text" class="form-control mt-3" round id="basicInput"
                                            name="edisi" value="{{ empty($item->edisi) ? '' : $item->edisi }}"
                                            required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="basicInput">Penerbit</label>
                                        <input type="text" class="form-control mt-3" round id="basicInput"
                                            name="penerbit" value="{{ empty($item->penerbit) ? '' : $item->penerbit }}"
                                            required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="basicInput">Tahun Terbit *</label>
                                        <input type="tel" min="1900" max="2099" maxlength="4"
                                            class="form-control mt-3" round id="basicInput" name="tahun_terbit"
                                            value="{{ empty($item->tahun_terbit) ? '' : $item->tahun_terbit }}" required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="basicInput">Tempat Penerbit</label>
                                        <input type="text" class="form-control mt-3" round id="basicInput"
                                            name="tempat_terbit"
                                            value="{{ empty($item->tempat_terbit) ? '' : $item->tempat_terbit }}">
                                    </div>
                                </div>
                                <div class="flex-end">
                                    <div class="form-group mb-3">
                                        <label for="basicInput">Deskripsi Fisik</label>
                                        <input type="text" class="form-control mt-3" round id="basicInput"
                                            name="deskripsi_fisik"
                                            value="{{ empty($item->deskripsi_fisik) ? '' : $item->deskripsi_fisik }}"
                                            required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="basicInput">Judul Seri</label>
                                        <input type="text" class="form-control mt-3" round id="basicInput"
                                            name="judul_seri"
                                            value="{{ empty($item->judul_seri) ? '' : $item->judul_seri }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="basicInput">Nomor Panggilan</label>
                                        <input type="number" class="form-control mt-3" round id="basicInput"
                                            name="nomor_panggil"
                                            value="{{ empty($item->nomor_panggil) ? '' : $item->nomor_panggil }}"
                                            required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="basicInput">Bahasa</label>
                                        <input type="text" class="form-control mt-3" round id="basicInput"
                                            name="bahasa" value="{{ empty($item->bahasa) ? '' : $item->bahasa }}"
                                            required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="basicInput">No Klas</label>
                                        <input type="number" class="form-control mt-3" round id="basicInput"
                                            name="no_klas" value="{{ empty($item->no_klas) ? '' : $item->no_klas }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="basicInput">Pengarang</label>
                                        <input type="text" class="form-control mt-3" round id="basicInput"
                                            name="pengarang"
                                            value="{{ empty($item->pengarang) ? '' : $item->pengarang }}" required>
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
                                <input name="id" value="{{ $item->id }}" hidden>
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
        <div class="modal fade" id="modalDeleteBuku{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-center">
                        <h5 class="modal-title" id="exampleModalScrollableTitle">Hapus {{ $item->judul . '?' }}</h5>
                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Batal</span>
                        </button>
                        <form action="{{ route('admin.book.delete') }}" method="post">
                            @csrf
                            <input name="id" value="{{ $item->id }}" hidden>
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
        <div class="modal fade" id="modalDetailBuku{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-center">
                        <h5 class="modal-title" id="exampleModalScrollableTitle">Detail Buku {{ $item->judul }}</h5>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex justify-content-between">
                            <div class="flex-start">
                                <div class="form-group mb-3">
                                    <label for="basicInput">ISBN *</label>
                                    <input type="text" class="form-control mt-3" round id="basicInput" name="isbn"
                                        value="{{ empty($item->isbn) ? '' : $item->isbn }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Judul *</label>
                                    <input type="text" class="form-control mt-3" round id="basicInput" name="judul"
                                        value="{{ empty($item->judul) ? '' : $item->judul }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">GMD</label>
                                    <input type="text" class="form-control mt-3" round id="basicInput" name="gmd"
                                        value="{{ empty($item->gmd) ? '' : $item->gmd }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Edisi</label>
                                    <input type="text" class="form-control mt-3" round id="basicInput" name="edisi"
                                        value="{{ empty($item->edisi) ? '' : $item->edisi }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Penerbit</label>
                                    <input type="text" class="form-control mt-3" round id="basicInput"
                                        name="penerbit" value="{{ empty($item->penerbit) ? '' : $item->penerbit }}"
                                        required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Tahun Terbit *</label>
                                    <input type="tel" min="1900" max="2099" maxlength="4"
                                        class="form-control mt-3" round id="basicInput" name="tahun_terbit"
                                        value="{{ empty($item->tahun_terbit) ? '' : $item->tahun_terbit }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Tempat Penerbit</label>
                                    <input type="text" class="form-control mt-3" round id="basicInput"
                                        name="tempat_terbit"
                                        value="{{ empty($item->tempat_terbit) ? '' : $item->tempat_terbit }}">
                                </div>
                            </div>
                            <div class="flex-end">
                                <div class="form-group mb-3">
                                    <label for="basicInput">Deskripsi Fisik</label>
                                    <input type="text" class="form-control mt-3" round id="basicInput"
                                        name="deskripsi_fisik"
                                        value="{{ empty($item->deskripsi_fisik) ? '' : $item->deskripsi_fisik }}"
                                        required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Judul Seri</label>
                                    <input type="text" class="form-control mt-3" round id="basicInput"
                                        name="judul_seri"
                                        value="{{ empty($item->judul_seri) ? '' : $item->judul_seri }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Nomor Panggilan</label>
                                    <input type="number" class="form-control mt-3" round id="basicInput"
                                        name="nomor_panggil"
                                        value="{{ empty($item->nomor_panggil) ? '' : $item->nomor_panggil }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Bahasa</label>
                                    <input type="text" class="form-control mt-3" round id="basicInput" name="bahasa"
                                        value="{{ empty($item->bahasa) ? '' : $item->bahasa }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">No Klas</label>
                                    <input type="number" class="form-control mt-3" round id="basicInput" name="no_klas"
                                        value="{{ empty($item->no_klas) ? '' : $item->no_klas }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Pengarang</label>
                                    <input type="text" class="form-control mt-3" round id="basicInput" name="bahasa"
                                        value="{{ empty($item->bahasa) ? '' : $item->bahasa }}" required>
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
    @endforeach

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
