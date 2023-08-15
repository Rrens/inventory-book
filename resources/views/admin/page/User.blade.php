@extends('admin.components.master')
@section('title', 'USER MANAGEMENT')
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
            <h3>User Control</h3>
        </div>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <p>Admin Table</p>
                                <button class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#modalTambahUser">Tambah</button>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped" id="table1">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>ID Admin</th>
                                            <th>Username</th>
                                            <th>Alamat</th>
                                            <th>No HP</th>
                                            <th>Gender</th>
                                            <th>Aksi</th>
                                            <th>Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            @if ($item->jenis_user == 0)
                                                <tr>
                                                    <td class="text-bold-500">
                                                        {{ $loop->iteration }}
                                                    </td>
                                                    <td class="text-bold-500">
                                                        {{ $item->id }}
                                                    </td>
                                                    <td class="text-bold-500">
                                                        {{ $item->username }}
                                                    </td>
                                                    <td class="text-bold-500">
                                                        {{ $item->alamat }}
                                                    </td>
                                                    <td class="text-bold-500">
                                                        {{ $item->phone }}
                                                    </td>
                                                    <td class="text-bold-500">
                                                        {{ $item->gender == 0 ? 'Laki-laki' : 'Perempuan' }}
                                                    </td>
                                                    <td>
                                                        <a class="tagA btn btn-outline-warning" href="#"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modalEditAdmin{{ $item->id }}">
                                                            <i class="bi bi-pencil-fill"></i>
                                                        </a>
                                                        <a class="tagA btn btn-outline-danger" href="#"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modalDeleteAdmin{{ $item->id }}">
                                                            <i class="bi bi-trash-fill"></i>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a class="tagA btn btn-primary" href="#"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modalDetailAdmin{{ $item->id }}"><i
                                                                class="bi bi-exclamation-triangle-fill"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <p>Anggota Table</p>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table1">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>ID Member</th>
                                                <th>Nama Member</th>
                                                <th>Alamat</th>
                                                <th>No HP</th>
                                                <th>Gender</th>
                                                <th>Aksi</th>
                                                <th>Detail</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $item)
                                                @if ($item->jenis_user == 1)
                                                    <tr>
                                                        <td class="text-bold-500">
                                                            {{ $loop->iteration }}
                                                        </td>
                                                        <td class="text-bold-500">
                                                            {{ $item->id }}
                                                        </td>
                                                        <td class="text-bold-500">
                                                            {{ $item->username }}
                                                        </td>
                                                        <td class="text-bold-500">
                                                            {{ $item->alamat }}
                                                        </td>
                                                        <td class="text-bold-500">
                                                            {{ $item->phone }}
                                                        </td>
                                                        <td class="text-bold-500">
                                                            {{ $item->gender == 0 ? 'Laki-laki' : 'Perempuan' }}
                                                        </td>
                                                        <td>
                                                            <a class="tagA btn btn-outline-warning" href="#"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#modalEditAdmin{{ $item->id }}">
                                                                <i class="bi bi-pencil-fill"></i>
                                                            </a>
                                                            <a class="tagA btn btn-outline-danger" href="#"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#modalDeleteAdmin{{ $item->id }}">
                                                                <i class="bi bi-trash-fill"></i>
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <a class="tagA btn btn-primary" href="#"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#modalDetailAdmin{{ $item->id }}"><i
                                                                    class="bi bi-exclamation-triangle-fill"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    {{-- MODAL TAMBAH --}}
    <div class="modal fade" id="modalTambahUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-center">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Tambah Profile</h5>
                </div>
                <form action="{{ route('admin.user.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="d-flex justify-content-between">
                            <div class="flex-start">
                                <div class="form-group mb-3">
                                    <label for="basicInput">Jenis User *</label>
                                    <select class="form-select mt-3" id="choose_user" name="jenis_user" required>
                                        <option selected hidden>Pilih Jenis User</option>
                                        <option value="0" {{ old('jenis_user') == 0 ? 'selected' : '' }}>Admin
                                        </option>
                                        <option value="1" {{ old('jenis_user') == 1 ? 'selected' : '' }}>Anggota
                                        </option>
                                    </select>

                                </div>
                                <div class="form-group mb-3" id="type_anggota" hidden>
                                    <label for="basicInput">Type Anggota *</label>
                                    <select class="form-select mt-3" id="choose_user" name="type_anggota" required>
                                        <option selected hidden>Pilih Jenis User</option>
                                        <option value="0" {{ old('type_anggota') == 0 ? 'selected' : '' }}>Siswa
                                        </option>
                                        <option value="1" {{ old('type_anggota') == 1 ? 'selected' : '' }}>Guru
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Email</label>
                                    <input type="email" class="form-control mt-3"round id="basicInput" name="email"
                                        value="{{ old('email') }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Kode Pos</label>
                                    <input type="tel" class="form-control mt-3"round id="basicInput" name="kode_pos"
                                        value="{{ old('kode_pos') }}" maxlength="5">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">No HP *</label>
                                    <input type="tel" class="form-control mt-3"round id="basicInput" name="phone"
                                        required maxlength="12" minlength="10" value="{{ old('phone') }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Nama Instansi *</label>
                                    <input type="text" class="form-control mt-3" round id="basicInput"
                                        name="nama_instansi" value="SMAN 3 Lamongan" required readonly
                                        value="{{ old('nama_instansi') }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Alamat Lengkap</label>
                                    <textarea type="text" class="form-control mt-3"round id="basicInput" name="alamat">{{ old('alamat') }}</textarea>
                                </div>

                            </div>
                            <div class="flex-end">
                                <div class="form-group mb-3">
                                    <label for="basicInput">Tanggal Input *</label>
                                    <input type="date" class="form-control mt-3"round id="basicInput"
                                        name="tgl_input" required value="{{ $date }}"
                                        value="{{ old('date') }}" readonly>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Username *</label>
                                    <input type="text" class="form-control mt-3"round id="basicInput" name="username"
                                        value="{{ old('username') }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Jenis Kelamin *</label>
                                    <select class="form-select mt-3" id="basicSelect" name="gender" required>
                                        <option selected hidden>Pilih Jenis Kelamin</option>
                                        <option value="0" {{ old('gender') == '0' ? 'selected' : '' }}>Laki-laki
                                        </option>
                                        <option value="1" {{ old('gender') == '1' ? 'selected' : '' }}>Perempuan
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Tanggal Lahir *</label>
                                    <input type="date" class="form-control mt-3" round id="basicInput"
                                        name="tgl_Lahir" value="{{ old('tgl_Lahir') }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Password</label>
                                    <input type="text" class="form-control mt-3"round id="basicInput" name="password"
                                        value="{{ old('password') }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="basicInput">Image</label>
                            <input type="file" class="form-control mt-3"round id="basicInput" name="image"
                                value="{{ old('image') }}">
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
        <div class="modal fade" id="modalEditAdmin{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-center">
                        <h5 class="modal-title" id="exampleModalScrollableTitle">Edit Profile
                            {{ $item->jenis_user == 0 ? 'Admin' : 'Anggota' }}</h5>
                    </div>
                    <form action="{{ route('admin.user.update') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="d-flex justify-content-between">
                                <div class="flex-start">
                                    <div class="form-group mb-3">
                                        <label for="basicInput">Jenis User *</label>
                                        <select class="form-select mt-3" name="jenis_user" id="choose_user_edit"
                                            required>
                                            <option value="{{ $item->jenis_user }}"
                                                {{ $item->jenis_user == 0 ? 'selected' : '' }}>
                                                {{ $item->jenis_user == 0 ? 'Admin' : 'Anggota' }}
                                            </option>
                                        </select>
                                    </div>
                                    @if ($item->jenis_user == 1)
                                        <div class="form-group mb-3" id="type_anggota">
                                            <label for="basicInput">Type Anggota *</label>
                                            <select class="form-select mt-3" id="type_anggota_edit" name="type_anggota"
                                                required>
                                                <option selected hidden>Pilih Jenis
                                                </option>
                                                <option value="0" {{ $item->type_anggota == 0 ? 'selected' : '' }}>
                                                    Siswa
                                                </option>
                                                <option value="1" {{ $item->type_anggota == 1 ? 'selected' : '' }}>
                                                    Guru
                                                </option>
                                            </select>
                                        </div>
                                    @endif
                                    <div class="form-group mb-3">
                                        <label for="basicInput">Email</label>
                                        <input type="email" class="form-control mt-3"round id="basicInput"
                                            name="email" value="{{ $item->email }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="basicInput">Kode Pos</label>
                                        <input type="number" class="form-control mt-3"round id="basicInput"
                                            name="kode_pos" value="{{ $item->kode_pos }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="basicInput">No HP *</label>
                                        <input type="number" class="form-control mt-3"round id="basicInput"
                                            name="phone" required value="{{ $item->phone }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="basicInput">Nama Instansi *</label>
                                        <input type="text" class="form-control mt-3" round id="basicInput"
                                            name="nama_instansi" value="SMAN 3 Lamongan" required readonly
                                            value="{{ $item->nama_instansi }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="basicInput">Alamat Lengkap</label>
                                        <textarea type="text" class="form-control mt-3"round id="basicInput" name="alamat">{{ $item->alamat }}</textarea>
                                    </div>

                                </div>
                                <div class="flex-end">
                                    <div class="form-group mb-3">
                                        <label for="basicInput">Tanggal Input *</label>
                                        <input type="date" class="form-control mt-3"round id="basicInput"
                                            name="tgl_input" required value="{{ $item->tanggal_input }}" readonly>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="basicInput">Username *</label>
                                        <input type="text" class="form-control mt-3"round id="basicInput"
                                            name="username" value="{{ $item->username }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="basicInput">Jenis Kelamin *</label>
                                        <select class="form-select mt-3" id="basicSelect" name="gender" required>
                                            <option selected hidden>Pilih Jenis Kelamin</option>
                                            <option value="0" {{ $item->gender == 0 ? 'selected' : '' }}>Laki-laki
                                            </option>
                                            <option value="1" {{ $item->gender == 1 ? 'selected' : '' }}>Perempuan
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="basicInput">Tanggal Lahir *</label>
                                        <input type="date" class="form-control mt-3" round id="basicInput"
                                            name="tgl_lahir" value="{{ $item->tanggal_lahir }}" required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="basicInput">Password</label>
                                        <input type="number" class="form-control mt-3"round id="basicInput"
                                            name="password">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="basicInput">Image</label>
                                <input type="file" class="form-control mt-3"round id="basicInput" name="image"
                                    value="{{ $item->image }}">
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
        <div class="modal fade" id="modalDeleteAdmin{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-center">
                        <h5 class="modal-title" id="exampleModalScrollableTitle">Hapus
                            {{ $item->jenis_user == 0 ? 'Admin' : 'Anggota' }} {{ $item->username . '?' }}</h5>
                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Batal</span>
                        </button>
                        <form action="{{ route('admin.user.delete') }}" method="post">
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
        <div class="modal fade" id="modalDetailAdmin{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-center">
                        <h5 class="modal-title" id="exampleModalScrollableTitle">Detail Profile
                            {{ $item->jenis_user == 0 ? 'Admin' : 'Anggota' }}</h5>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex justify-content-between">
                            <div class="flex-start">
                                <div class="form-group mb-3">
                                    <label for="basicInput">Jenis User *</label>
                                    <input type="email" class="form-control mt-3" round
                                        value="{{ $item->jenis_user == 0 ? 'Admin' : 'Anggota' }}">
                                </div>
                                @if ($item->jenis_user == 1)
                                    <div class="form-group mb-3" id="type_anggota">
                                        <label for="basicInput">Type Anggota *</label>
                                        <input type="email" class="form-control mt-3"round
                                            value="{{ $item->type_anggota == 0 ? 'Siswa' : 'Guru' }}">
                                    </div>
                                @endif
                                <div class="form-group mb-3">
                                    <label for="basicInput">Email</label>
                                    <input type="email" class="form-control mt-3"round id="basicInput" name="email"
                                        value="{{ $item->email }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Kode Pos</label>
                                    <input type="number" class="form-control mt-3"round id="basicInput" name="kode_pos"
                                        value="{{ $item->kode_pos }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">No HP *</label>
                                    <input type="number" class="form-control mt-3"round id="basicInput" name="phone"
                                        required value="{{ $item->phone }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Nama Instansi *</label>
                                    <input type="text" class="form-control mt-3" round id="basicInput"
                                        name="nama_instansi" value="SMAN 3 Lamongan" required readonly
                                        value="{{ $item->nama_instansi }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Alamat Lengkap</label>
                                    <textarea type="text" class="form-control mt-3"round id="basicInput" name="alamat">{{ $item->alamat }}</textarea>
                                </div>

                            </div>
                            <div class="flex-end">
                                <div class="form-group mb-3">
                                    <label for="basicInput">Tanggal Input *</label>
                                    <input type="date" class="form-control mt-3"round id="basicInput"
                                        name="tgl_input" required value="{{ $item->tanggal_input }}" readonly>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Username *</label>
                                    <input type="text" class="form-control mt-3"round id="basicInput" name="username"
                                        value="{{ $item->username }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Jenis Kelamin *</label>
                                    {{ $item->gender == 0 ? 'Admin' : 'Anggota' }}
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Tanggal Lahir *</label>
                                    <input type="date" class="form-control mt-3" round id="basicInput"
                                        name="tgl_lahir" value="{{ $item->tanggal_lahir }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="basicInput">Password</label>
                                    <input type="number" class="form-control mt-3"round id="basicInput"
                                        name="password">
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="basicInput">Image</label>
                            <input type="file" class="form-control mt-3"round id="basicInput" name="image"
                                value="{{ $item->image }}">
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
