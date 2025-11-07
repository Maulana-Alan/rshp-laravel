@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Daftar Pet') }}</div>

                <div class="card-body">
                    <a href="{{ route('admin.pet.create') }}" class="btn btn-primary mb-3">
                        Tambah Pet
                    </a>
                    
                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pet</th>
                                <th>Nama Pemilik</th>
                                <th>Ras Hewan</th>
                                <th>Tanggal Lahir</th>
                                <th>Jenis Kelamin</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pets as $index => $pet)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $pet->nama }}</td>
                                <td>{{ $pet->pemilik->user->nama }}</td>
                                <td>{{ $pet->rasHewan->nama_ras }}</td>
                                <td>{{ $pet->tanggal_lahir }}</td>
                                <td>{{ $pet->jenis_kelamin == 'J' ? 'Jantan' : 'Betina' }}</td>
                                <td>
                                    <a href="#" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="#" class="btn btn-danger btn-sm">Hapus</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">Data masih kosong.</td>
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