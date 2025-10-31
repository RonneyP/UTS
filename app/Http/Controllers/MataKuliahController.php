<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use Illuminate\Http\Request;

class MataKuliahController extends Controller
{
    public function index()
    {
        return view('IndexMataKuliah', ['matakuliah' => MataKuliah::all()]);
    }

    public function create()
    {
        return view('CreateMataKuliah');
    }

     public function store(Request $request)
    {
        $request->validate([
            'kode'  => 'required|unique:matakuliah,kode',
            'nama_matakuliah'  => 'required',
        ]);

        \App\Models\MataKuliah::create($request->all());

        return redirect('/matakuliah')->with('success', 'Mata Kuliah Berhasil Ditambahkan');
    }

    public function show(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        $matakuliah = MataKuliah::findOrFail($id);
        $request->validate([
            'kode'   => 'required|unique:matakuliah,kode,',
            'nama_matakuliah'   => 'required'
        ]);

        $matakuliah->update($request->all());
        return redirect('/matakuliah')->with('success','Data Mata Kuliah berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $matakuliah = MataKuliah::findOrFail($id);
        $matakuliah->delete();

        return redirect('/matakuliah')->with('success','Data Mata Kuliah berhasil dihapus.');
    }
}


