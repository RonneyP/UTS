<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use App\Models\Mahasiswa;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $mk_id = $request->get('matakuliah_id');
        $tanggal = $request->get('tanggal_absensi', now()->toDateString());

        $mata_kuliahs = MataKuliah::all();
        $mahasiswas = Mahasiswa::orderBy('NIM')->get();

        $absensi_data = [];

        if ($mk_id) {
            // Ambil data absensi yang sudah ada untuk MK dan Tanggal yang dipilih
            $existing_absensi = Absensi::where('matakuliah_id', $mk_id)
                                        ->where('tanggal_absensi', $tanggal)
                                        ->get();
            
            // Konversi menjadi array asosiatif (mahasiswa_id => status_absen)
            foreach ($existing_absensi as $absensi) {
                $absensi_data[$absensi->mahasiswa_id] = $absensi->status_absen;
            }
        }

        return view('IndexAbsensi', [
            'mata_kuliahs' => $mata_kuliahs,
            'mahasiswas' => $mahasiswas,
            'mk_id' => $mk_id,
            'tanggal' => $tanggal,
            'absensi_data' => $absensi_data,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'matakuliah_id' => 'required|uuid|exists:matakuliah,id',
            'tanggal_absensi' => 'required|date',
        ]);

        $mk_id = $request->input('matakuliah_id');
        $tanggal = $request->input('tanggal_absensi');
        
        $mahasiswas = Mahasiswa::all();

        DB::beginTransaction();
        try {
            foreach ($mahasiswas as $mhs) {
                $input_name = 'status_' . $mhs->id; 
                $status = $request->input($input_name);

                if ($status && in_array($status, ['A', 'H', 'I', 'S'])) {  
                    Absensi::updateOrCreate(
                        [
                            'mahasiswa_id' => $mhs->id,
                            'matakuliah_id' => $mk_id, 
                            'tanggal_absensi' => $tanggal,
                        ],
                        [
                            'status_absen' => $status, 
                        ]
                    );
                }
            }

            DB::commit();
            return redirect()->route('absensi.index', [
                'matakuliah_id' => $mk_id, 
                'tanggal_absensi' => $tanggal
            ])->with('success', 'Absensi berhasil disimpan/diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan absensi: ' . $e->getMessage());
        }
    }
}
