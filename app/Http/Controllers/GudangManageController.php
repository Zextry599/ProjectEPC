<?php

namespace App\Http\Controllers;

use App\Models\GudangStock;
use App\Models\Product;
use App\Models\Distribusi;
use App\Models\Store;
use Illuminate\Http\Request;

class GudangManageController extends Controller
{

    public function index()
    {
        $stocks = GudangStock::all();
        return view('gudang.index', compact('stocks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|unique:gudang_stocks',
            'nama_barang' => 'required',
            'merk' => 'nullable|string',
            'stok_box' => 'required|integer|min:0',
            'harga' => 'nullable|integer',
        ]);

        GudangStock::create($request->all());
        return redirect()->route('gudang.index')->with('success', 'Stok gudang berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $stock = GudangStock::findOrFail($id);
        return response()->json($stock); // ✅ ubah dari return view jadi JSON
    }

    public function update(Request $request, $id)
    {
        $stock = GudangStock::findOrFail($id);
        $data = $request->validate([
            'nama_barang' => 'required',
            'berat_barang' => 'nullable',
            'merk' => 'nullable',
            'stok_box' => 'required|integer|min:0',
            'harga' => 'required|integer|min:0',
        ]);

        $data['keterangan'] = ($data['stok_box'] > 0) ? 'tersedia' : 'habis';

        $stock->update($data);
        return redirect()->route('gudang.index')->with('success', 'Barang gudang berhasil diperbarui.');
    }


    public function distribusiForm($id)
    {
        $gudang = GudangStock::findOrFail($id);
        $stores = Store::all(); // daftar semua toko

        return view('gudang.distribusi', compact('gudang', 'stores'));
    }

    public function distribusi(Request $request, $id)
    {
        $request->validate([
            'store_id' => 'required|exists:stores,id',
            'jumlah' => 'required|integer|min:1',
            'pengirim' => 'required',
            'penerima' => 'required',
        ]);

        $gudang = GudangStock::findOrFail($id);
        if ($gudang->stok < $request->jumlah) {
            return redirect()->back()->with('error', 'Stok gudang tidak mencukupi.');
        }

        // Kurangi stok gudang
        $gudang->stok -= $request->jumlah;
        $gudang->save();

        // Tambah ke tabel products (toko)
        $product = Product::where('store_id', $request->store_id)
            ->where('kode_barang', $gudang->kode_barang)
            ->first();

        if ($product) {
            $product->stok += $request->jumlah;
            $product->save();
        } else {
            Product::create([
                'store_id' => $request->store_id,
                'kode_barang' => $gudang->kode_barang,
                'nama_barang' => $gudang->nama_barang,
                'merk' => $gudang->merk,
                'stok_box' => $request->jumlah,
                'harga' => $gudang->harga,
            ]);
        }

        // Simpan distribusi
        Distribusi::create([
            'gudang_stock_id' => $gudang->id,
            'store_id' => $request->store_id,
            'jumlah' => $request->jumlah,
            'pengirim' => $request->pengirim,
            'penerima' => $request->penerima,
        ]);

        return redirect()->route('gudang.index')->with('success', 'Distribusi berhasil dilakukan.');
    }
}
