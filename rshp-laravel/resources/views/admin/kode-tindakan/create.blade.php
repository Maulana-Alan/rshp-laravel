@extends('layouts.app')

@section('title', 'Tambah Kode Tindakan')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Tambah Kode Tindakan Terapi</div>

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

                    <form action="{{ route('admin.kode-tindakan.store') }}" method="POST">
                        @csrf 

                        <div class="form-group mb-3">
                            <label for="kode" class="form-label">
                                Kode <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('kode') is-invalid @enderror" 
                                   id="kode" 
                                   name="kode" 
                                   value="{{ old('kode') }}" 
                                   placeholder="Masukkan kode (maks 5 karakter)" 
                                   required>
                            @error('kode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="deskripsi_tindakan" class="form-label">
                                Deskripsi Tindakan <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('deskripsi_tindakan') is-invalid @enderror" 
                                      id="deskripsi_tindakan" 
                                      name="deskripsi_tindakan" 
                                      rows="3" 
                                      placeholder="Masukkan deskripsi" 
                                      required>{{ old('deskripsi_tindakan') }}</textarea>
                            @error('deskripsi_tindakan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="idkategori" class="form-label">
                                Kategori <span class="text-danger">*</span>
                            </label>
                            <select class="form-control @error('idkategori') is-invalid @enderror" 
                                    id="idkategori" name="idkategori" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->idkategori }}" {{ old('idkategori') == $kategori->idkategori ? 'selected' : '' }}>
                                        {{ $kategori->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('idkategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="idkategori_klinis" class="form-label">
                                Kategori Klinis <span class="text-danger">*</span>
                            </label>
                            <select class="form-control @error('idkategori_klinis') is-invalid @enderror" 
                                    id="idkategori_klinis" name="idkategori_klinis" required>
                                <option value="">Pilih Kategori Klinis</option>
                                @foreach($kategoriKlinis as $kategori)
                                    <option value="{{ $kategori->idkategori_klinis }}" {{ old('idkategori_klinis') == $kategori->idkategori_klinis ? 'selected' : '' }}>
                                        {{ $kategori->nama_kategori_klinis }}
                                    </option>
                                @endforeach
                            </select>
                            @error('idkategori_klinis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.kode-tindakan.index') }}" class="btn btn-secondary">
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