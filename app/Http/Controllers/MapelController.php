<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use App\Http\Requests\StoreMapelRequest;
use App\Http\Requests\UpdateMapelRequest;
use App\Models\Mengajar;
use Illuminate\Http\Request;

class MapelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mapel = Mapel::all();
        return view('mapel.index', compact('mapel'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mapel.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_mapel' => ['required', 'unique:mapels'],
        ]);
        Mapel::create($data);
        return redirect('/mapel/index')->with('success', 'Data Mapel Berhasil diTambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(Mapel $mapel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mapel $mapel)
    {
        return view('mapel.edit', compact('mapel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mapel $mapel)
    {
        $data = $request->validate([
            'nama_mapel' => ['required', 'unique:mapels,nama_mapel,' . $mapel->id],
        ]);
        $mapel->update($data);
        return redirect('/mapel/index')->with('success', 'Data Mapel Berhasil diUbah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mapel $mapel)
    {
        $mengajar = Mengajar::where('mapel_id', $mapel->id)->first();
        if ($mengajar) {
            return back()->with('error', "$mapel->nama_mapel Masih diGunakan di Menu Mengajar");
        }
        $mapel->delete();
        return redirect('/mapel/index')->with('success', 'Data Mapel Berhasil di Hapus');
    }
}
