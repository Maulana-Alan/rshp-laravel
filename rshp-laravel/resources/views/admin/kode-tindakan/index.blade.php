@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Daftar Kode Tindakan Terapi') }}</div>

                <div class="card-body">
                    <a href="{{ route('admin.kode-tindakan.create') }}" class="btn btn-primary mb-3">
                        Tambah Kode Tindakan
                    </a>
                    
                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Deskripsi Tindakan</th>
                                <th>Kategori</th>
                                <th>Kategori Klinis</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kodeTindakan as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->kode }}</td>
                                <td>{{ $item->deskripsi_tindakan }}</td>
                                <td>{{ $item->kategori->nama_kategori }}</td>
                                <td>{{ $item->kategoriKlinis->nama_kategori_klinis }}</td>
                                <td>
                                    <a href="#" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="#" class="btn btn-danger btn-sm">Hapus</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Data masih kosong.</td>
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