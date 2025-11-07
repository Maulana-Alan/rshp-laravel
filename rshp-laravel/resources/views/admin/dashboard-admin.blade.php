@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10"> <div class="card">
                <div class="card-header">{{ __('Dashboard Administrator') }} - {{ session('user_name') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }} sebagai: <strong>{{ session('user_role_name') }}</strong>

                    <div class="mt-4">
                        <h4>Manajemen Data Master</h4>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <a href="{{ route('admin.user.index') }}" class="btn btn-primary btn-block">Daftar User</a>
                            </div>
                            <div class="col-md-6 mb-2">
                                <a href="{{ route('admin.role.index') }}" class="btn btn-primary btn-block">Daftar Role</a>
                            </div>
                            <div class="col-md-6 mb-2">
                                <a href="{{ route('admin.jenis-hewan.index') }}" class="btn btn-primary btn-block">Daftar Jenis Hewan</a>
                            </div>
                            <div class="col-md-6 mb-2">
                                <a href="{{ route('admin.ras-hewan.index') }}" class="btn btn-primary btn-block">Daftar Ras Hewan</a>
                            </div>
                            <div class="col-md-6 mb-2">
                                <a href="{{ route('admin.pemilik.index') }}" class="btn btn-primary btn-block">Daftar Pemilik</a>
                            </div>
                            <div class="col-md-6 mb-2">
                                <a href="{{ route('admin.pet.index') }}" class="btn btn-primary btn-block">Daftar Pet</a>
                            </div>
                            <div class="col-md-6 mb-2">
                                <a href="{{ route('admin.kategori.index') }}" class="btn btn-primary btn-block">Daftar Kategori</a>
                            </div>
                            <div class="col-md-6 mb-2">
                                <a href="{{ route('admin.kategori-klinis.index') }}" class="btn btn-primary btn-block">Daftar Kategori Klinis</a>
                            </div>
                            <div class="col-md-6 mb-2">
                                <a href="{{ route('admin.kode-tindakan.index') }}" class="btn btn-primary btn-block">Daftar Kode Tindakan</a>
                            </div>
                            <div class="col-md-6 mb-2">
    <a href="{{ route('admin.pendaftaran.index') }}" class="btn btn-warning btn-block">Daftar Pendaftaran</a>
</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection