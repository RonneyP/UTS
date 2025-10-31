<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Mata Kuliah</title>
    <!-- Tambahkan link Bootstrap dan Ikon -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light">

  <div class="container py-5">
    
    <!-- Notifikasi Session Success -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Header & Tombol Create -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="fw-bold text-primary">Daftar Mata Kuliah</h2>
      <a href="{{ route('matakuliah.create') }}" class="btn btn-success shadow-sm">
        <i class="bi bi-plus-lg me-1"></i> Tambah Mata Kuliah
      </a>
    </div>

    <!-- Kartu Tabel -->
    <div class="card shadow border-0 rounded-4">
      <div class="card-body p-4">
        <div class="table-responsive">
          <table class="table table-hover table-striped align-middle">
            <thead class="table-primary text-white">
              <tr>
                <th scope="col">No</th>
                <th scope="col">Kode MK</th>
                <th scope="col">Nama MK</th>
                <th scope="col">Aksi</th>
              </tr>
            </thead>
            <tbody>
              {{-- Pastikan variabel dikirim dari Controller dengan nama 'matakuliah' --}}
              @forelse ($matakuliah as $index => $mk) 
              <tr>
                <td>{{ $index + 1 }}</td> {{-- Penomoran otomatis --}}
                <td>{{ $mk->kode }}</td> 
                <td>{{ $mk->nama_matakuliah }}</td> 
                <td>
                  <div class="d-flex gap-2">
                    <a href="{{ route('matakuliah.edit', $mk->id) }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-pencil-square"></i> Edit
                    </a>
                    
                    <form action="{{ route('matakuliah.destroy', $mk->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus mata kuliah: {{ $mk->nama_matakuliah }}?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-danger">
                          <i class="bi bi-trash"></i> Hapus
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="4" class="text-center text-muted py-4">
                    <i class="bi bi-info-circle me-2"></i> Belum ada data mata kuliah yang tercatat.
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
          
          {{-- Tautan Pagination --}}
          {{-- @if (isset($matakuliah->links))
            <div class="mt-3">
              {{ $matakuliah->links() }}
            </div>
          @endif --}}

        </div>
      </div>
    </div>

  </div>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

