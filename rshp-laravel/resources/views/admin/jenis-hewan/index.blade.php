@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Daftar Jenis Hewan') }}</div>

                <div class="card-body">
                    <a href="{{ route('admin.jenis-hewan.create') }}" class="btn btn-primary mb-3">
                        Tambah Jenis Hewan
                    </a>
                    
                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Jenis Hewan</th>
                                <th>Aksi</th> </tr>
                        </thead>
                        <tbody>
                            @forelse ($jenisHewan as $index => $hewan)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $hewan->nama_jenis_hewan }}</td>
                                <td>
                                    <a href="#" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="#" class="btn btn-danger btn-sm">Hapus</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center">Data masih kosong.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection