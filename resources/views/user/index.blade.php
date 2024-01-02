    {{-- memanggil file template --}}
    @extends('layout.template')

    {{--isi bagian yield--}}
    @section('content')
        @if (Session::get('success'))
        <div class="alert alert-success">
            {{Session::get('success')}}
        </div>
        @endif
        @if (Session::get('deleted'))
            <div class="alert alert-warning">
                {{Session::get('deleted')}}
            </div>
        @endif
        <button type="submit" class="btn btn-primary"><a class="dropdown-item" href="{{ route('user.create') }}">Tambah Data</a></button>
        <table class="table mt-5 table-stripped table-bordered table-hovered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $no =1; @endphp
                @foreach ($users as $item)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{$item['name']}}</td>
                    <td>{{$item['email']}}</td>
                    <td>{{$item['role']}}</td>
                    <td class="d-flex">
                        <a href="{{ route('user.edit', $item['id']) }}" class="btn btn-success">Edit</a>
                        {{--method ::delete  tidak bisa digunakan pada a href, harus melalui form action --}}
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Hapus
                        </button>
                        
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Data</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Yakin Mau Di Hapus Ni?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <form action="{{ route('user.delete', $item['id']) }}" method="post" class="ms-3">
                                        @csrf 
                                        {{-- menimpa/mengubah method="post" agar menjadi method="delete" sesuai dengan method route (::'DELETE') --}}
                                        @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    </td>
                </tr>
    
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-end">
            @if ($users->count())
            {{$users->links()}}
            @endif
        </div>
    @endsection 