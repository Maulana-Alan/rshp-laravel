@extends('layouts.app')

@section('title', 'Tambah Kategori Klinis')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Tambah Kategori Klinis</div>

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

                    <form action="{{ route('admin.kategori-klinis.store') }}" method="POST">
                        @csrf 

                        <div class="form-group mb-3">
                            <label for="nama_kategori_klinis" class="form-label">
                                Nama Kategori Klinis <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('nama_kategori_klinis') is-invalid @enderror" 
                                   id="nama_kategori_klinis" 
                                   name="nama_kategori_klinis" 
                                   value="{{ old('nama_kategori_klinis') }}" 
                                   placeholder="Masukkan nama kategori klinis" 
                                   required>
                            @error('nama_kategori_klinis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.kategori-klinis.index') }}" class="btn btn-secondary">
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