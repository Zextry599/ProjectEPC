<?php

namespace App\Http\Controllers\ERP;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\ErpProduct;
use App\Models\Supplier;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        $orders = PurchaseOrder::with('supplier')->orderBy('tanggal', 'desc')->get();
        return view('erp.purchase.index', compact('orders'));
    }

    public function destroy($id)
    {
        $order = PurchaseOrder::findOrFail($id);

        // Hapus semua item terkait
        $order->items()->delete();

        // Hapus PO utama
        $order->delete();

        return redirect()->route('purchase.index')->with('success', 'Purchase order berhasil dihapus.');
    }


    public function show($id)
    {
        $order = PurchaseOrder::with(['supplier', 'items.product'])->findOrFail($id);
        return view('erp.purchase.show', compact('order'));
    }
    public function create()
    {
        $suppliers = Supplier::all();
        $products = ErpProduct::all();
        return view('erp.purchase.create', compact('suppliers', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'supplier_id' => 'required|exists:suppliers,id',
            'product_id' => 'required|array|min:1',
            'product_id.*' => 'exists:erp_products,id',
            'jumlah' => 'required|array|min:1',
            'jumlah.*' => 'integer|min:1',
            'harga_satuan' => 'required|array|min:1',
            'harga_satuan.*' => 'integer|min:0',
            'status' => 'required|in:Pending,Diproses,Selesai,Dibatalkan',
        ]);


        DB::beginTransaction();

        try {
            $kode_pembelian = 'PO-' . strtoupper(Str::random(6));

            $po = PurchaseOrder::create([
                'kode_pembelian' => $kode_pembelian,
                'supplier_id' => $request->supplier_id,
                'tanggal' => $request->tanggal,
                'catatan' => $request->catatan,
                'status' => $request->status ?? 'Pending',
            ]);

            foreach ($request->product_id as $i => $product_id) {
                PurchaseOrderItem::create([
                    'purchase_order_id' => $po->id,
                    'erp_product_id' => $product_id,
                    'jumlah' => $request->jumlah[$i],
                    'harga_satuan' => $request->harga_satuan[$i],
                ]);
            }

            // Tambah stok jika PO selesai
            if ($request->status === 'Selesai') {
                foreach ($po->items as $item) {
                    $product = ErpProduct::find($item->erp_product_id);
                    if ($product) {
                        $product->stok += $item->jumlah;
                        $product->save();
                    }
                }
            }

            DB::commit();
            return redirect()->route('purchase.index')->with('success', 'Purchase Order berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $order = PurchaseOrder::with('items')->findOrFail($id);
        $suppliers = Supplier::all();
        $products = ErpProduct::all();

        return view('erp.purchase.edit', compact('order', 'suppliers', 'products'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'tanggal' => 'required|date',
            'product_id.*' => 'required|exists:erp_products,id',
            'jumlah.*' => 'required|integer|min:1',
            'harga_satuan.*' => 'required|integer|min:0',
            'status' => 'required|in:Pending,Diproses,Selesai,Dibatalkan',
        ]);

        $order = PurchaseOrder::with('items')->findOrFail($id);
        $oldStatus = $order->status;

        // Hitung dulu pengaruh stok dari item lama jika status sebelumnya Selesai
        if ($oldStatus === 'Selesai') {
            foreach ($order->items as $item) {
                $product = ErpProduct::find($item->erp_product_id);
                if ($product) {
                    $product->stok -= $item->jumlah;  // rollback stok
                    $product->save();
                }
            }
        }

        // Update data PO
        $order->update([
            'supplier_id' => $request->supplier_id,
            'tanggal' => $request->tanggal,
            'catatan' => $request->catatan,
            'status' => $request->status,
        ]);

        // Hapus item lama
        $order->items()->delete();

        // Tambah item baru
        foreach ($request->product_id as $index => $productId) {
            $order->items()->create([
                'erp_product_id' => $productId,
                'jumlah' => $request->jumlah[$index],
                'harga_satuan' => $request->harga_satuan[$index],
            ]);
        }

        // Jika status sekarang Selesai, tambahkan stok
        if ($request->status === 'Selesai') {
            foreach ($order->items as $item) {
                $product = ErpProduct::find($item->erp_product_id);
                if ($product) {
                    $product->stok += $item->jumlah;
                    $product->save();
                }
            }
        }

        return redirect()->route('purchase.index')->with('success', 'Purchase order berhasil diperbarui.');
    }
}
