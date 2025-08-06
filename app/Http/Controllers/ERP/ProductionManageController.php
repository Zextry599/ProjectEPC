<?php

namespace App\Http\Controllers\ERP;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Production;
use App\Models\ProductionMaterial;
use App\Models\ErpProduct;
use App\Models\MasterProduct;

class ProductionManageController extends Controller
{
    public function index()
    {
        $productions = Production::with('masterProduct')->orderBy('tanggal_produksi', 'desc')->get();
        return view('erp.production.index', compact('productions'));
    }

    public function create()
    {
        $materials = ErpProduct::all(); // bahan mentah
        $finishedProducts = MasterProduct::all(); // barang jadi
        return view('erp.production.create', compact('materials', 'finishedProducts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_produksi' => 'required|date',
            'master_product_id' => 'required|exists:master_products,id',
            'jumlah_produksi' => 'required|integer|min:1',
            'material_id.*' => 'required|exists:erp_products,id',
            'jumlah_dipakai.*' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            $kode_produksi = 'PROD-' . strtoupper(Str::random(6));

            $production = Production::create([
                'kode_produksi' => $kode_produksi,
                'tanggal_produksi' => $request->tanggal_produksi,
                'master_product_id' => $request->master_product_id,
                'jumlah_produksi' => $request->jumlah_produksi,
                'catatan' => $request->catatan,
            ]);

            // Simpan bahan mentah yang dipakai
            foreach ($request->material_id as $i => $materialId) {
                ProductionMaterial::create([
                    'production_id' => $production->id,
                    'erp_product_id' => $materialId,
                    'jumlah_dipakai' => $request->jumlah_dipakai[$i],
                ]);

                // Kurangi stok bahan mentah
                $erpProduct = ErpProduct::find($materialId);
                if ($erpProduct) {
                    $erpProduct->stok -= $request->jumlah_dipakai[$i];
                    $erpProduct->save();
                }
            }

            // Tambah stok barang jadi
            $masterProduct = MasterProduct::find($request->master_product_id);
            $masterProduct->stok += $request->jumlah_produksi;
            $masterProduct->save();

            DB::commit();
            return redirect()->route('production.index')->with('success', 'Proses produksi berhasil disimpan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $production = Production::with(['masterProduct', 'materials.erpProduct'])->findOrFail($id);
        return view('erp.production.show', compact('production'));
    }
}
