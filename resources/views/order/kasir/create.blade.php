@extends('layout.template')

@section('content')
    <form action="{{ route('order.store') }}" class="card p-4 mt-5" method="POST">
        @csrf
        @if ($errors->any())
        <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        @endif
        <div class="mb-3 d-flex align-items-center">
            <label for="name_customer" class="form-label" style="width: 15%">Penanggung Jawab :</label>
            <p style="margin-top: 10px"><b>{{ Auth::user()->name }}</b></p>
        </div>
        <div class="mb-3 d-flex align-items-center">
            <label for="name_customer" class="form-label" style="width: 12%">Nama Pembeli :</label>
            <input type="text" name="name_customer" id="name_customer" class="form-control" style="width: 88%">
        </div>
        <div class="mb-3">
            <div class="d-flex align-items-center">
            <label for="medicines" class="form-label" style="width: 12%">Obat :</label>
            <select name="medicines[]" id="medicines" class="form-control" style="width: 88%">
                {{-- name dengan [] biasanya dipakai buat colum yang tipe datanya json/array, dan biasanya digunakan apabila input dengan tujuan data yang sama ada banyak (dan dari banyak input yang datanya sama tsb) --}}
                <option selected hidden disabled>Pesanan 1</option>
                @foreach ($medicines as $medicine)
                    <option value="{{ $medicine['id'] }}">{{ $medicine['name'] }}</option>
                @endforeach
                {{-- karena akan ada js yang menampilkan select ketika di click, maka sediakan temapat penyimpanan element yang akan dihasilkan dari js tersebut --}}
            </select>
            </div>
            <div id="wrap-select" class="mt-3"></div>
            <p class="text-primary" style="margin-left: 125px; cursor: pointer" onclick="addSelect()">+ tambah pesanan</p>
        </div>
        <button type="submit" class="btn btn-primary">Konfirmasi Pembelian</button>
    </form>
@endsection

@push('script')
    <script>
        let no = 2;
        function addSelect() {
            let el = `<div class="d-flex align-items-center mb-3">
                        <label for="medicines" class="form-label" style="width: 12%"></label>
                        <select name="medicines[]" id="medicines" class="form-control" style="width: 88%">
                        <option selected hidden disabled>Pesanan ${no}</option>
                        @foreach ($medicines as $medicine)
                        <option value="{{ $medicine['id'] }}">{{ $medicine['name'] }}</option>
                        @endforeach
                        </select>
                     </div>`;
                     $("#wrap-select").append(el);
                     no++;
        }
    </script>
@endpush