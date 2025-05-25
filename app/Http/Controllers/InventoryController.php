<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $inventories = Inventory::all();
        return view('inventory.index', compact('inventories'));
    }

    public function create()
    {
        return view('inventory.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|string',
            'nama_barang' => 'required|string',
            'jumlah_barang' => 'required|integer|min:0',
            'satuan_barang' => 'required|string',
            'harga_beli' => 'required|numeric|min:0',
        ]);

        Inventory::create([
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'jumlah_barang' => $request->jumlah_barang,
            'satuan_barang' => $request->satuan_barang,
            'harga_beli' => $request->harga_beli,
            'status_barang' => $request->jumlah_barang > 0 ? 1 : 0,
        ]);

        return redirect()->route('inventory.index')->with('success', 'Barang berhasil ditambahkan');
    }

    public function edit($id_barang)
    {
        $item = Inventory::where('id_barang', $id_barang)->firstOrFail();
        return view('inventory.edit', compact('item'));
    }

    public function update(Request $request, $id_barang)
    {
        $request->validate([
            'kode_barang' => 'required|string',
            'nama_barang' => 'required|string',
            'jumlah_barang' => 'required|integer|min:0',
            'satuan_barang' => 'required|string',
            'harga_beli' => 'required|numeric|min:0',
        ]);

        $item = Inventory::where('id_barang', $id_barang)->firstOrFail();
        $item->update([
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'jumlah_barang' => $request->jumlah_barang,
            'satuan_barang' => $request->satuan_barang,
            'harga_beli' => $request->harga_beli,
            'status_barang' => $request->jumlah_barang > 0 ? 1 : 0,
        ]);

        return redirect()->route('inventory.index')->with('success', 'Barang berhasil diupdate');
    }

    public function destroy($id_barang)
    {
        $item = Inventory::where('id_barang', $id_barang)->firstOrFail();
        $item->delete();

        return redirect()->route('inventory.index')->with('success', 'Barang berhasil dihapus');
    }

    public function pinjam($id_barang)
    {
        $item = Inventory::where('id_barang', $id_barang)->firstOrFail();

        if ($item->jumlah_barang > 0) {
            $item->jumlah_barang -= 1;
            $item->status_barang = $item->jumlah_barang > 0 ? 1 : 0;
            $item->save();

            return redirect()->route('inventory.index')->with('success', 'Kamu berhasil meminjam barang');
        }

        return redirect()->route('inventory.index')->with('error', 'Stok barang habis');
    }

    public function tambahStok(Request $request, $id_barang)
    {
        $request->validate([
            'jumlah_tambah' => 'required|integer|min:1',
        ]);

        $item = Inventory::where('id_barang', $id_barang)->firstOrFail();
        $item->jumlah_barang += $request->jumlah_tambah;
        $item->status_barang = 1;
        $item->save();

        return redirect()->route('inventory.index')->with('success', 'Stok berhasil ditambahkan');
    }
}
