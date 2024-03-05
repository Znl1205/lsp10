<?php

namespace App\Http\Controllers;

use App\Models\Mengajar;
use App\Http\Requests\StoreMengajarRequest;
use App\Http\Requests\UpdateMengajarRequest;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Nilai;
use Illuminate\Http\Request;

class MengajarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mengajar = Mengajar::all();
        return view('mengajar.index', compact('mengajar'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $guru = Guru::all();
        $mapel = Mapel::all();
        $kelas = Kelas::all();
        return view('mengajar.create', compact('guru', 'mapel', 'kelas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'guru_id' => ['required'],
            'mapel_id' => ['required'],
            'kelas_id' => ['required'],
        ]);
        $cek = Mengajar::where('mapel_id', $request->mapel_id)->where('kelas_id', $request->kelas_id)->first();
        if ($cek) {
            return back()->with('error', 'Data Yang Anda Masukan Sudah Ada');
        }
        Mengajar::create($data);
        return redirect('/mengajar/index')->with('success', 'Data Mengajar Berhasil diTambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(Mengajar $mengajar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mengajar $mengajar)
    {
        $guru = Guru::all();
        $mapel = Mapel::all();
        $kelas = Kelas::all();
        return view('mengajar.edit', compact('mengajar', 'guru', 'mapel', 'kelas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mengajar $mengajar)
    {
        $data = $request->validate([
            'guru_id' => ['required'],
            'mapel_id' => ['required'],
            'kelas_id' => ['required'],
        ]);
        if ($request->mapel_id != $mengajar->mapel_id || $request->kelas_id != $mengajar->kelas_id) {
            $cek = Mengajar::where('mapel_id', $request->mapel_id)->where('kelas_id', $request->kelas_id)->first();
            if ($cek) {
                return back()->with('error', 'Data Yang Anda Masukan Sudah Ada');
            }
        }
        $mengajar->update($data);
        return redirect('/mengajar/index')->with('success', 'Data Mengajar Berhasil diUbah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mengajar $mengajar)
    {
        $nilai = Nilai::where('mengajar_id', $mengajar->id)->first();
        if ($nilai) {
            return back()->with('error', " Masih diGunakan di Menu Nilai");
        }
        $mengajar->delete();
        return redirect('/mengajar/index')->with('success', 'Data Mengajar Berhasil di Hapus');
    }
}
