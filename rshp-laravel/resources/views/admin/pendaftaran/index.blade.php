@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Data Pendaftaran Pasien (Admin View)') }}</div>

                <div class="card-body">
                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th>No. Antrian</th>
                                <th>Waktu Daftar</th>
                                <th>Nama Pet</th>
                                <th>Dokter Tujuan</th>
                                <th>Resepsionis</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pendaftarans as $item)
                            <tr>
                                <td>{{ $item->no_antrian }}</td>
                                <td>{{ $item->waktu_daftar }}</td>
                                <td>{{ $item->pet->nama ?? 'Pet Dihapus' }}</td>
                                <td>{{ $item->dokter->nama ?? 'Dokter TBD' }}</td>
                                <td>{{ $item->resepsionis->nama ?? 'N/A' }}</td>
                                <td>{{ $item->status }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada data pendaftaran.</td>
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