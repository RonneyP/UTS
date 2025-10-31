<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($mahasiswa) ? 'Edit Mahasiswa: ' . $mahasiswa->name : 'Tambah Mahasiswa Baru' }}</title>
    <!-- Bootstrap 5.3 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        body { background-color: #f8f9fa; }
        .card { max-width: 800px; margin: 0 auto; }
    </style>
</head>
<body> 
    <div class="container py-5">
        <h2 class="fw-bold text-dark text-center mb-4">
            {{ isset($mahasiswa) ? 'Edit Data Mahasiswa' : 'Tambah Data Mahasiswa Baru' }}
        </h2>
        
        <div class="card shadow border-0">
            <div class="card-body p-4 p-md-5">
                
                <!-- PERBAIKAN: Menggunakan route yang benar berdasarkan keberadaan $mahasiswa -->
                <form action="{{ isset($mahasiswa) ? route('mahasiswa.update', ['mahasiswa' => $mahasiswa->id]) : route('mahasiswa.store') }}" method="POST">
                    @csrf
                    
                    <!-- METODE PUT untuk Update -->
                    @if(isset($mahasiswa))
                        @method('PUT')
                    @endif

                    <!-- Input Nama -->
                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold">Nama Lengkap</label>
                        <!-- PERBAIKAN: Menggunakan old() untuk sticky form dan operator null-coalescing untuk data edit -->
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $mahasiswa->name ?? '') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Input NIM -->
                    <div class="mb-3">
                        <label for="NIM" class="form-label fw-bold">NIM (Nomor Induk Mahasiswa)</label>
                        <input type="text" class="form-control @error('NIM') is-invalid @enderror" id="NIM" name="NIM" value="{{ old('NIM', $mahasiswa->NIM ?? '') }}" required>
                        @error('NIM')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Input Tempat Lahir -->
                    <div class="mb-3">
                        <label for="tempat_lahir" class="form-label fw-bold">Tempat Lahir</label>
                        <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir', $mahasiswa->tempat_lahir ?? '') }}">
                        @error('tempat_lahir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Input Tanggal Lahir -->
                    <div class="mb-3">
                        <label for="tanggal_lahir" class="form-label fw-bold">Tanggal Lahir</label>
                        <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $mahasiswa->tanggal_lahir ?? '') }}">
                        @error('tanggal_lahir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Dropdown Jurusan -->
                    <div class="mb-3">
                        <label for="jurusan" class="form-label fw-bold">Jurusan</label>
                        @php
                            $currentJurusan = old('jurusan', $mahasiswa->jurusan ?? '');
                        @endphp
                        <div class="d-flex flex-column gap-2">
                            @foreach(['Bisnis Digital', 'Kewirausahaan', 'Sistem dan Teknologi Informasi'] as $jurusan)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="jurusan" id="{{ Str::slug($jurusan) }}" value="{{ $jurusan }}" 
                                        {{ $currentJurusan === $jurusan ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="{{ Str::slug($jurusan) }}">
                                        {{ $jurusan }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        @error('jurusan')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Input Angkatan -->
                    <div class="mb-4">
                        <label for="angkatan" class="form-label fw-bold">Tahun Angkatan</label>
                        <input type="number" class="form-control @error('angkatan') is-invalid @enderror" id="angkatan" name="angkatan" value="{{ old('angkatan', $mahasiswa->angkatan ?? '') }}" min="2000" max="{{ date('Y') }}" placeholder="{{ date('Y') }}">
                        @error('angkatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="d-flex justify-content-between pt-3">
                        <a href="{{ route('mahasiswa.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Batal / Kembali
                        </a>
                        <button type="submit" class="btn btn-primary shadow">
                            <i class="bi bi-save me-1"></i> {{ isset($mahasiswa) ? 'Perbarui Data' : 'Simpan Data' }}
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
