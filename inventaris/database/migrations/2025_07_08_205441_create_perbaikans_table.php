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
            $table->string('nama_bengkel');
            $table->string('kategori'); // ringan / berat
            $table->text('detail_perbaikan');
            $table->integer('jumlah')->default(1);
            $table->bigInteger('harga_per_pcs');
            $table->string('foto_kerusakan')->nullable();
            $table->string('foto_nota')->nullable();
            $table->date('tanggal_perbaikan')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->enum('status', ['pending', 'proses', 'selesai'])->default('pending');
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
