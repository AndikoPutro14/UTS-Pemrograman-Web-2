<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('inventories', function (Blueprint $table) {
        $table->id('id_barang');
        $table->string('kode_barang');
        $table->string('nama_barang');
        $table->integer('jumlah_barang');
        $table->string('satuan_barang');
        $table->decimal('harga_beli', 15, 2);
        $table->boolean('status_barang')->default(1); // 1 = available
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
