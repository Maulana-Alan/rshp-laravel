@extends('layouts.app')

@section('title', 'Lengkapi Profil')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        
        {{-- Pesan Sukses --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        {{-- Pesan Error Validasi --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow mb-4">
            <div class="card-header py-3 bg-primary">
                <h6 class="m-0 font-weight-bold text-white">Form Data Diri</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf

                    {{-- Ambil Nama Role User yang Login --}}
                    @php
                        $roleName = $user->roles->first()->nama_role ?? '';
                        $isDokter = stripos($roleName, 'Dokter') !== false;
                        $isPerawat = stripos($roleName, 'Perawat') !== false;
                    @endphp

                    {{-- INFO USER (Read Only) --}}
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama User</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control-plaintext" value="{{ $user->nama }}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Role / Jabatan</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control-plaintext font-weight-bold" value="{{ $roleName }}" readonly>
                        </div>
                    </div>
                    
                    <hr>

                    {{-- FORM ISIAN UMUM (Alamat, HP, JK) --}}
                    {{-- Muncul untuk Dokter & Perawat --}}
                    @if($isDokter || $isPerawat)
                        
                        {{-- Tentukan Data Lama (Jika ada) --}}
                        @php
                            if($isDokter) {
                                $data = $dokterData;
                            } else {
                                $data = $perawatData;
                            }
                        @endphp

                        <div class="form-group">
                            <label>Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control" rows="3" required>{{ old('alamat', $data->alamat ?? '') }}</textarea>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <label>No HP / WhatsApp</label>
                                <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp', $data->no_hp ?? '') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label>Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-control" required>
                                    <option value="">- Pilih -</option>
                                    <option value="L" {{ (old('jenis_kelamin', $data->jenis_kelamin ?? '') == 'L') ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ (old('jenis_kelamin', $data->jenis_kelamin ?? '') == 'P') ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                        </div>

                        {{-- KHUSUS DOKTER --}}
                        @if($isDokter)
                            <div class="form-group">
                                <label class="text-primary font-weight-bold">Bidang Keahlian Dokter</label>
                                <input type="text" name="bidang_dokter" class="form-control" placeholder="Contoh: Dokter Umum, Bedah, dll" value="{{ old('bidang_dokter', $data->bidang_dokter ?? '') }}" required>
                                <small class="text-muted">Wajib diisi untuk Dokter.</small>
                            </div>
                        @endif

                        {{-- KHUSUS PERAWAT --}}
                        @if($isPerawat)
                            <div class="form-group">
                                <label class="text-success font-weight-bold">Pendidikan Terakhir</label>
                                <input type="text" name="pendidikan" class="form-control" placeholder="Contoh: D3 Keperawatan, S1 Ners" value="{{ old('pendidikan', $data->pendidikan ?? '') }}" required>
                                <small class="text-muted">Wajib diisi untuk Perawat.</small>
                            </div>
                        @endif

                        <button type="submit" class="btn btn-primary btn-block mt-4">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>

                    @else
                        {{-- JIKA BUKAN DOKTER/PERAWAT (Misal Admin) --}}
                        <div class="alert alert-info">
                            Anda login sebagai <strong>{{ $roleName }}</strong>. Tidak ada data tambahan yang perlu dilengkapi.
                        </div>
                    @endif

                </form>
            </div>
        </div>
    </div>
</div>
@endsection