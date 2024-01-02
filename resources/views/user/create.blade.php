@extends('layout.template')

@section('content')
    <form action="{{route('user.store')}}" method="post">
        {{--sebagai token akses ke database --}}
        @csrf
        {{--jika terjadi error validasi, akan ditambahkan bagian errornya --}}
        @if ($errors->any())
        <ul class="alert-alert-danger p-5">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        @endif
        {{-- jika berhasil munculkan errornya--}}
        @if (Session::get('success'))
            <div class="alert alert-success"> {{ Session::get('success' ) }}</div>
        @endif
        <div class="mb-3 mt-5 row">
            <label for="name" class="col-sm-2 col-form-label">Nama :</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="email" class="col-sm-2 col-form-label">Email :</label>
        <div class="col-sm-10">
            <input type="email" class="form-control" id="email" name="email">
        </div>
        </div>
        <div class="mb-3 row">
            <label for="role" class="col-sm-2 col-form-label">Tipe Pengguna :</label>
            <div class="col-sm-10">
                <select id="role" class="form-control" name="role">
                    <option disabled hidden selected>Pilih</option>
                    <option value="admin">Admin</option>
                    <option value="cashier">Kasir</option>
                </select>
            </div>
        </div>
        {{-- <div class="mb-3 row">
            <label for="password" class="col-sm-2 col-form-label hidden">Password :</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="password" name="password">
            </div> --}}
        <button type="submit" class="btn btn-primary">Simpan Data</button>
    </form>
@endsection