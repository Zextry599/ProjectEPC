<?php

namespace App\Http\Controllers\ERP;

use App\Http\Controllers\Controller;
use App\Models\ErpProduct;
use Illuminate\Http\Request;

class ErpProductManageController extends Controller
{
    public function index()
    {
        $products = ErpProduct::all();
        return view('erp.erproduct.index', compact('products'));
    }

    public function create()
    {
        return view('erp.erproduct.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|unique:erp_products',
            'nama_barang' => 'required',
            'jenis_barang' => 'required',
            'harga' => 'required|numeric',
            'berat' => 'required|numeric',
            'satuan' => 'required|string',
        ]);

        // Gabungkan berat + satuan
        $berat_barang = $request->berat . ' ' . $request->satuan;

        // Buat data
        ErpProduct::create([
            'kode_barang'   => $request->kode_barang,
            'nama_barang'   => $request->nama_barang,
            'jenis_barang'  => $request->jenis_barang,
            'merek'         => $request->merek,
            'berat_barang'  => $berat_barang,
            'stok'          => $request->stok ?? 0,
            'harga'         => $request->harga,
        ]);

        return redirect()->route('erproduct.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(ErpProduct $erproduct)
    {
        // Pisahkan berat dan satuan (misalnya: "2 kg" jadi ["2", "kg"])
        $beratParts = explode(' ', $erproduct->berat_barang);
        $berat = $beratParts[0] ?? '';
        $satuan = $beratParts[1] ?? '';

        return view('erp.erproduct.edit', compact('erproduct', 'berat', 'satuan'));
    }

    public function update(Request $request, ErpProduct $erproduct)
    {
        $request->validate([
            'nama_barang' => 'required',
            'jenis_barang' => 'required',
            'harga' => 'required|numeric',
            'berat' => 'required|numeric',
            'satuan' => 'required|string',
        ]);

        $berat_barang = $request->berat . ' ' . $request->satuan;

        $erproduct->update([
            'nama_barang'   => $request->nama_barang,
            'jenis_barang'  => $request->jenis_barang,
            'merek'         => $request->merek,
            'berat_barang'  => $berat_barang,
            'stok'          => $request->stok ?? 0,
            'harga'         => $request->harga,
        ]);

        return redirect()->route('erproduct.index')->with('success', 'Produk berhasil diupdate.');
    }

    public function destroy(ErpProduct $erproduct)
    {
        $erproduct->delete();

        return redirect()->route('erproduct.index')->with('success', 'Produk berhasil dihapus.');
    }
}
