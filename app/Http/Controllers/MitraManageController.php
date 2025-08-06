<?php

namespace App\Http\Controllers;

use App\Models\Mitra;
use Illuminate\Http\Request;

class MitraManageController extends Controller
{
    public function index()
    {
        $mitra = Mitra::all();
        return view('mitra.index', compact('mitra'));
    }

    public function create()
    {
        return view('mitra.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'telepon' => 'required',
            'alamat' => 'required',
            'email' => 'required|email',
        ]);

        // Buat data mitra dengan status default 'aktif'
        $mitraData = $request->all();
        $mitraData['status'] = 'aktif'; // Set default status

        Mitra::create($mitraData);
        return redirect()->route('mitra.index')->with('success', 'Data mitra berhasil ditambahkan');
    }

    public function edit($id)
    {
        $mitra = Mitra::findOrFail($id);
        return response()->json($mitra);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'telepon' => 'required',
            'alamat' => 'required',
            'status' => 'required|in:aktif,non-aktif'
        ]);

        $mitra = Mitra::findOrFail($id);
        $mitra->update($request->all());

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $mitra = Mitra::findOrFail($id);
        $mitra->delete();

        return redirect()->route('mitra.index')->with('success', 'Data mitra berhasil dihapus');
    }
}
