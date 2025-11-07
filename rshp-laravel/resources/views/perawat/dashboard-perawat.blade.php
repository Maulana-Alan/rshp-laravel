@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard Perawat') }} - {{ session('user_name') }}</div>

                <div class="card-body">
                    <div class="mt-4">
                        <h4>Daftar Pendaftaran Pasien</h4>
                        <table class="table table-bordered mt-3">
                            <thead>
                                <tr>
                                    <th>Antrian</th>
                                    <th>Waktu Daftar</th>
                                    <th>Pet</th>
                                    <th>Dokter</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pendaftarans as $item)
                                <tr>
                                    <td>{{ $item->no_antrian }}</td>
                                    <td>{{ $item->waktu_daftar }}</td>
                                    <td>{{ $item->pet->nama ?? 'N/A' }}</td>
                                    <td>{{ $item->dokter->nama ?? 'N/A' }}</td>
                                    <td>{{ $item->status }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada data pendaftaran.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-5">
                        <h4>Daftar Rekam Medis</h4>
                        <table class="table table-bordered mt-3">
                            <thead>
                                <tr>
                                    <th>Waktu</th>
                                    <th>Pet</th>
                                    <th>Dokter Pemeriksa</th>
                                    <th>Diagnosa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($rekamMedis as $item)
                                <tr>
                                    <td>{{ $item->created_at }}</td>
                                    <td>{{ $item->pet->nama ?? 'N/A' }}</td>
                                    <td>{{ $item->dokterPemeriksa->nama ?? 'N/A' }}</td>
                                    <td>{{ $item->diagnosa }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada data rekam medis.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection