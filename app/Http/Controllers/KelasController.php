<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Http\Requests\StoreKelasRequest;
use App\Http\Requests\UpdateKelasRequest;
use App\Models\Mengajar;
use App\Models\Siswa;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kelas = Kelas::all();
        return view('kelas.index', compact('kelas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $Kelas = ['10', '11', '12', '13'];
        $Jurusan = ['DKV', 'DPIB', 'BKP', 'RPL', 'SIJA', 'TKJ', 'TKR', 'TP', 'TFLM', 'TOI'];
        return view('kelas.create', compact('Kelas', 'Jurusan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'kelas' => ['required'],
            'jurusan' => ['required'],
            'rombel' => ['required'],
        ]);
        $kelas = Kelas::firstOrNew($data);
        if ($kelas->exists) {
            return back()->with('error', 'Data Yang Anda Masukan Sudah Ada');
        } else {
            Kelas::create($data);
            return redirect('/kelas/index')->with('success', 'Data Kelas Berhasil diTambah');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Kelas $kelas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kelas $kelas)
    {
        $Kelas = ['10', '11', '12', '13'];
        $Jurusan = ['DKV', 'DPIB', 'BKP', 'RPL', 'SIJA', 'TKJ', 'TKR', 'TP', 'TFLM', 'TOI'];
        return view('kelas.edit', compact('kelas', 'Kelas', 'Jurusan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kelas $kelas)
    {
        $data = $request->validate([
            'kelas' => ['required'],
            'jurusan' => ['required'],
            'rombel' => ['required'],
        ]);
        if ($request->kelas != $kelas->kelas || $request->jurusan != $kelas->jurusan || $request->rombel != $kelas->rombel) {
            $cek = Kelas::where('kelas', $request->kelas)->where('jurusan', $request->jurusan)->where('rombel', $request->rombel)->first();
            if ($cek) {
                return back()->with('error', 'Data Yang Anda Masukan Sudah Ada');
            }
        }
        $kelas->update($data);
        return redirect('/kelas/index')->with('success', 'Data Kelas Berhasil diUbah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kelas $kelas)
    {
        $mengajar = Mengajar::where('kelas_id', $kelas->id)->first();
        $siswa = Siswa::where('kelas_id', $kelas->id)->first();

        $Kelas = "$kelas->kelas $kelas->jurusan $kelas->rombel";
        if ($mengajar) {
            return back()->with('error', "$Kelas Masih diGunakan di Menu Mengajar");
        } elseif ($siswa) {
            return back()->with('error', "$Kelas Masih diGunakan di Menu Siswa");
        } else {
            $kelas->delete();
            return redirect('/kelas/index')->with('success', 'Data Kelas Berhasil di Hapus');
        }
    }
}
