<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Mata Kuliah Baru</title>
    <!-- Link Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light">

  <div class="container py-5">
    
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="fw-bold text-primary">Tambah Mata Kuliah Baru</h2>
      <a href="{{ url('/matakuliah') }}" class="btn btn-secondary shadow-sm">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
      </a>
    </div>

    <!-- Kartu Formulir -->
    <div class="card shadow border-0 rounded-4">
      <div class="card-body p-4 p-md-5">
        
        <!-- Formulir POST ke Controller Store Method -->
        <form action="{{ route('matakuliah.store') }}" method="POST">
          @csrf
          
          <!-- Input Kode Mata Kuliah -->
          <div class="mb-4">
            <label for="kode" class="form-label fw-bold">Kode Mata Kuliah</label>
            <input 
                type="text" 
                class="form-control @error('kode') is-invalid @enderror" 
                id="kode" 
                name="kode" 
                value="{{ old('kode') }}" 
                placeholder="Contoh: SB01"
                required
            >
            @error('kode')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
          </div>

          <!-- Input Nama Mata Kuliah -->
          <div class="mb-4">
            <label for="nama_matakuliah" class="form-label fw-bold">Nama Mata Kuliah</label>
            <input 
                type="text" 
                class="form-control @error('nama_matakuliah') is-invalid @enderror" 
                id="nama_matakuliah" 
                name="nama_matakuliah" 
                value="{{ old('nama_matakuliah') }}" 
                placeholder="Contoh: Algoritma"
                required
            >
            @error('nama_matakuliah')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
          </div>

          <!-- Tombol Simpan -->
          <div class="d-grid mt-4">
            <button type="submit" class="btn btn-primary btn-lg shadow-sm">
              <i class="bi bi-save me-2"></i> Simpan Mata Kuliah
            </button>
          </div>
          
        </form>

      </div>
    </div>

  </div>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
