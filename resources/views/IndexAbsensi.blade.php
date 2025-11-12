<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Absensi Mahasiswa</title>
    <!-- Bootstrap 5.3 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        body { background-color: #f0f2f5; }
        .absensi-container { max-width: 1000px; margin: 20px auto; }
        .table-responsive { border-radius: 8px; overflow: hidden; }
        .status-header { width: 80px; text-align: center; }
        .table th, .table td { vertical-align: middle; }
    </style>
</head>
<body> 
    <div class="container py-5 absensi-container">
        <h2 class="fw-bold text-center text-primary mb-4">
            <i class="bi bi-calendar-check me-2"></i> Pengisian Absensi
        </h2>

        <!-- Pesan Sukses/Error -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Filter Mata Kuliah dan Tanggal -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form action="{{ route('absensi.index') }}" method="GET" class="row g-3 align-items-end">
                    
                    <div class="col-md-6">
                        <label for="matakuliah_id" class="form-label fw-bold">Pilih Mata Kuliah</label>
                        <select class="form-select" id="matakuliah_id" name="matakuliah_id" required>
                            <option value="">-- Pilih Mata Kuliah --</option>
                            @foreach($mata_kuliahs as $mk)
                                <option value="{{ $mk->id }}" {{ $mk_id == $mk->id ? 'selected' : '' }}>
                                    {{ $mk->kode_mk }} - {{ $mk->nama_mk }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="tanggal_absensi" class="form-label fw-bold">Tanggal Absensi</label>
                        <input type="date" class="form-control" id="tanggal_absensi" name="tanggal_absensi" 
                               value="{{ $tanggal }}" required>
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-search"></i> Tampilkan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabel Absensi -->
        @if($mk_id)
            <div class="card shadow border-0">
                <div class="card-header bg-white">
                    <h5 class="mb-0 fw-bold">Daftar Mahasiswa Kelas</h5>
                    <p class="text-muted mb-0 small">Absensi untuk: {{ \Carbon\Carbon::parse($tanggal)->isoFormat('dddd, D MMMM Y') }}</p>
                </div>
                <div class="card-body p-0">
                    <form action="{{ route('absensi.store') }}" method="POST">
                        @csrf
                        
                        <!-- Hidden Inputs -->
                        <input type="hidden" name="matakuliah_id" value="{{ $mk_id }}">
                        <input type="hidden" name="tanggal_absensi" value="{{ $tanggal }}">

                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" style="width: 50px;">#</th>
                                        <th scope="col" style="width: 150px;">NIM</th>
                                        <th scope="col">Nama Mahasiswa</th>
                                        <th scope="col" class="status-header">Hadir</th>
                                        <th scope="col" class="status-header">Izin</th>
                                        <th scope="col" class="status-header">Sakit</th>
                                        <th scope="col" class="status-header">Alpha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($mahasiswas as $mhs)
                                        @php
                                            $current_status = $absensi_data[$mhs->id] ?? null;
                                        @endphp
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $mhs->NIM }}</td>
                                            <td>{{ $mhs->name }}</td>
                                            
                                            <!-- Pilihan Status Absensi -->
                                            @foreach(['H', 'I', 'S', 'A'] as $status)
                                                <td>
                                                    <div class="form-check text-center">
                                                        <input class="form-check-input" type="radio" 
                                                               name="status_{{ $mhs->id }}" 
                                                               id="status_{{ $mhs->id }}_{{ $status }}" 
                                                               value="{{ $status }}" 
                                                               {{ $current_status == $status ? 'checked' : '' }} 
                                                               required>
                                                        <label class="form-check-label visually-hidden" for="status_{{ $mhs->id }}_{{ $status }}">
                                                            {{ $status }}
                                                        </label>
                                                    </div>
                                                </td>
                                            @endforeach
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4">Tidak ada data Mahasiswa ditemukan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Tombol Simpan -->
                        @if($mahasiswas->count() > 0)
                            <div class="card-footer bg-light text-end">
                                <button type="submit" class="btn btn-success shadow-sm">
                                    <i class="bi bi-save me-1"></i> Simpan Absensi
                                </button>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        @else
            <div class="alert alert-info text-center py-4 shadow-sm">
                <i class="bi bi-info-circle-fill me-2"></i> Silakan pilih Mata Kuliah dan Tanggal untuk memulai pengisian absensi.
            </div>
        @endif

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>