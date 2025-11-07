@extends('layouts.app')

@section('title', 'Tambah Pet')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Tambah Pet Baru</div>

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

                    <form action="{{ route('admin.pet.store') }}" method="POST">
                        @csrf 

                        <div class="form-group mb-3">
                            <label for="idpemilik" class="form-label">
                                Pemilik <span class="text-danger">*</span>
                            </label>
                            <select class="form-control @error('idpemilik') is-invalid @enderror" 
                                    id="idpemilik" name="idpemilik" required>
                                <option value="">Pilih Pemilik</option>
                                @foreach($pemiliks as $pemilik)
                                    <option value="{{ $pemilik->idpemilik }}" {{ old('idpemilik') == $pemilik->idpemilik ? 'selected' : '' }}>
                                        {{ $pemilik->user->nama }} ({{ $pemilik->user->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('idpemilik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="idras_hewan" class="form-label">
                                Ras Hewan <span class="text-danger">*</span>
                            </label>
                            <select class="form-control @error('idras_hewan') is-invalid @enderror" 
                                    id="idras_hewan" name="idras_hewan" required>
                                <option value="">Pilih Ras Hewan</option>
                                @foreach($rasHewans as $ras)
                                    <option value="{{ $ras->idras_hewan }}" {{ old('idras_hewan') == $ras->idras_hewan ? 'selected' : '' }}>
                                        {{ $ras->nama_ras }} ({{ $ras->jenisHewan->nama_jenis_hewan }})
                                    </option>
                                @endforeach
                            </select>
                            @error('idras_hewan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="nama" class="form-label">
                                Nama Pet <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('nama') is-invalid @enderror" 
                                   id="nama" name="nama" 
                                   value="{{ old('nama') }}" 
                                   placeholder="Masukkan nama pet" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="tanggal_lahir" class="form-label">
                                Tanggal Lahir <span class="text-danger">*</span>
                            </label>
                            <input type="date" 
                                   class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                                   id="tanggal_lahir" name="tanggal_lahir" 
                                   value="{{ old('tanggal_lahir') }}" required>
                            @error('tanggal_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="jenis_kelamin" class="form-label">
                                Jenis Kelamin <span class="text-danger">*</span>
                            </label>
                            <select class="form-control @error('jenis_kelamin') is-invalid @enderror" 
                                    id="jenis_kelamin" name="jenis_kelamin" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="J" {{ old('jenis_kelamin') == 'J' ? 'selected' : '' }}>Jantan</option>
                                <option value="B" {{ old('jenis_kelamin') == 'B' ? 'selected' : '' }}>Betina</option>
                            </select>
                            @error('jenis_kelamin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="warna_tanda" class="form-label">Warna / Tanda</label>
                            <input type="text" 
                                   class="form-control @error('warna_tanda') is-invalid @enderror" 
                                   id="warna_tanda" name="warna_tanda" 
                                   value="{{ old('warna_tanda') }}" 
                                   placeholder="Misal: Belang hitam, ekor buntung">
                            @error('warna_tanda')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.pet.index') }}" class="btn btn-secondary">
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