@extends('layout.template')

@section('content')
    <form action="{{route('medicine.store')}}" method="post">
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
            <label for="name" class="col-sm-2 col-form-label">Nama Obat :</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="name" class="col-sm-2 col-form-label">Type Obat :</label>
            <div class="col-sm-10">
                <select id="type" class="form-control" name="type">
                    <option disabled hidden selected>Pilih</option>
                    <option value="tablet">Tablet</option>
                    <option value="sirup">Sirup</option>
                    <option value="kapsul">Kapsul</option>
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="price" class="col-sm-2 col-form-label">Harga Obat :</label>
        <div class="col-sm-10">
            <input type="number" class="form-control" id="price" name="price">
        </div>
        </div>
        <div class="mb-3 row">
            <label for="stock" class="col-sm-2 col-form-label">Stock Awal :</label>
            <div class="col-sm-10">
                <input type="number" class="form-control" id="stock" name="stock">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Data</button>
    </form>
@endsection