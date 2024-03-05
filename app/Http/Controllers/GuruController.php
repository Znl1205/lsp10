<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Http\Requests\StoreGuruRequest;
use App\Http\Requests\UpdateGuruRequest;
use App\Models\Mengajar;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $guru = Guru::all();
        return view('guru.index', compact('guru'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('guru.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nip' => ['required', 'numeric', 'unique:gurus'],
            'nama_guru' => ['required'],
            'jk' => ['required'],
            'alamat' => ['required'],
            'password' => ['required'],
        ]);
        Guru::create($data);
        return redirect('/guru/index')->with('success', 'Data Guru Berhasil diTambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(Guru $guru)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Guru $guru)
    {
        return view('guru.edit', compact('guru'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Guru $guru)
    {
        $data = $request->validate([
            'nip' => ['required', 'numeric', 'unique:gurus,nip,' . $guru->id],
            'nama_guru' => ['required'],
            'jk' => ['required'],
            'alamat' => ['required'],
            'password' => ['required'],
        ]);
        $guru->update($data);
        return redirect('/guru/index')->with('success', 'Data Guru Berhasil diUbah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Guru $guru)
    {
        $mengajar = Mengajar::where('guru_id', $guru->id)->first();
        if ($mengajar) {
            return back()->with('error', "$guru->nama_guru Masih diGunakan di Menu Mengajar");
        }
        $guru->delete();
        return redirect('/guru/index')->with('success', 'Data Guru Berhasil di Hapus');
    }
}
