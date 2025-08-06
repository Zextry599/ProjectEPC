<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class StoreManageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stores = Store::all();
        return view('manage_store.index', compact('stores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
            return view('manage_store.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'alamat' => 'nullable|string',
        ]);

        Store::create($request->all());
        Session::flash('create_success', 'Toko berhasil ditambahkan');
        return redirect()->route('store.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $store = Store::findOrFail($id);
        return response()->json($store);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string',
            'alamat' => 'nullable|string',
        ]);

        $store = Store::findOrFail($id);
        $store->update($request->all());

        Session::flash('update_success', 'Toko berhasil diperbarui');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Store::destroy($id);
        Session::flash('delete_success', 'Toko berhasil dihapus');
        return back();
    }
}
