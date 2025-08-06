<?php

namespace App\Http\Controllers\ERP;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MasterProduct;

class MasterProductManageController extends Controller
{
    public function index()
    {
        $products = MasterProduct::orderBy('created_at', 'desc')->get();
        return view('erp.masterproduct.index', compact('products'));
    }

    public function create()
    {
        return view('erp.masterproduct.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|unique:master_products,kode_barang',
            'nama_barang' => 'required',
            'kategori' => 'nullable|string',
            'merek' => 'nullable|string',
            'berat_barang' => 'nullable|string',
            'stok' => 'required|integer|min:0',
            'harga' => 'required|integer|min:0',
        ]);

        MasterProduct::create([
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'kategori' => $request->kategori,
            'merek' => $request->merek,
            'berat_barang' => $request->berat_barang,
            'stok' => $request->stok,
            'harga' => $request->harga,
        ]);

        return redirect()->route('masterproduct.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $product = MasterProduct::findOrFail($id);
        return view('erp.masterproduct.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = MasterProduct::findOrFail($id);

        $request->validate([
            'kode_barang' => 'required|unique:master_products,kode_barang,' . $product->id,
            'nama_barang' => 'required',
            'kategori' => 'nullable|string',
            'merek' => 'nullable|string',
            'berat_barang' => 'nullable|string',
            'stok' => 'required|integer|min:0',
            'harga' => 'required|integer|min:0',
        ]);

        $product->update([
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'kategori' => $request->kategori,
            'merek' => $request->merek,
            'berat_barang' => $request->berat_barang,
            'stok' => $request->stok,
            'harga' => $request->harga,
        ]);

        return redirect()->route('masterproduct.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $product = MasterProduct::findOrFail($id);
        $product->delete();

        return redirect()->route('masterproduct.index')->with('success', 'Produk berhasil dihapus.');
    }
}
