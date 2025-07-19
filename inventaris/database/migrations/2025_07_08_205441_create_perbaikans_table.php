<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('perbaikans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('kendaraan_id')->constrained('kendaraans')->onDelete('cascade');
            $table->date('tanggal_perbaikan');
            $table->string('nama_bengkel');
            $table->string('kategori');
            $table->string('sub_kategori');
            $table->text('detail_kerusakan');
            $table->string('komponen')->nullable();
            $table->integer('jumlah')->default(1);
            $table->string('satuan')->default('pcs');
            $table->integer('harga_per_pcs')->default(0);
            $table->integer('total_harga')->default(0);
            $table->string('foto_kerusakan')->nullable();
            $table->string('foto_nota')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perbaikans');
    }
};
