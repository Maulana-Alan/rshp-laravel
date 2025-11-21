@extends('layouts.app')

@section('title', 'Tambah Jenis Hewan')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Tambah Jenis Hewan</div>

                <div class="card-body">
                    @if ($errors->any())    
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.jenis-hewan.store') }}" method="POST">
                        @csrf <div class="form-group mb-3">
                            <label for="nama_jenis_hewan" class="form-label">
                                Nama Jenis Hewan <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('nama_jenis_hewan') is-invalid @enderror" 
                                   id="nama_jenis_hewan" 
                                   name="nama_jenis_hewan" 
                                   value="{{ old('nama_jenis_hewan') }}" 
                                   placeholder="Masukkan nama jenis hewan" 
                                   required>

                            @error('nama_jenis_hewan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.jenis-hewan.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection