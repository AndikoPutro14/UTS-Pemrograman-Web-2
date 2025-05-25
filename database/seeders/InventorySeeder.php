<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Inventory; // Your model
use Illuminate\Support\Str;

class InventorySeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 15; $i++) {
            Inventory::create([
                'kode_barang' => 'KD' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'nama_barang' => 'Barang ' . $i,
                'jumlah_barang' => rand(1, 50),
                'satuan_barang' => 'pcs',
                'harga_beli' => rand(10000, 50000),
                'status_barang' => 1,
            ]);
        }
    }
}
