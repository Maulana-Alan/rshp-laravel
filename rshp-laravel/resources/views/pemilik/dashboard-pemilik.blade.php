@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Dashboard Pemilik') }} - {{ session('user_name') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }} sebagai: <strong>{{ session('user_role_name') }}</strong>

                    <div class="mt-4">
                        <h4>Daftar Pet Milik Anda</h4>
                        <table class="table table-bordered mt-3">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pet</th>
                                    <th>Ras Hewan</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Jenis Kelamin</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pets as $index => $pet)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $pet->nama }}</td>
                                    <td>{{ $pet->rasHewan->nama_ras }}</td>
                                    <td>{{ $pet->tanggal_lahir }}</td>
                                    <td>{{ $pet->jenis_kelamin == 'J' ? 'Jantan' : 'Betina' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Anda belum mendaftarkan pet.</td>
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