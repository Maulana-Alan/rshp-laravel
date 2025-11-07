@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Daftar Ras Hewan') }}</div>

                <div class="card-body">
                    <a href="{{ route('admin.ras-hewan.create') }}" class="btn btn-primary mb-3">
                        Tambah Ras Hewan
                    </a>
                    
                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Ras Hewan</th>
                                <th>Jenis Hewan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($rasHewan as $index => $ras)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $ras->nama_ras }}</td>
                                <td>{{ $ras->jenisHewan->nama_jenis_hewan }}</td>
                                <td>
                                    <a href="#" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="#" class="btn btn-danger btn-sm">Hapus</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">Data masih kosong.</td>
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