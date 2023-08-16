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
        Schema::create('bukus', function (Blueprint $table) {
            $table->id();
            $table->text('isbn');
            $table->string('penerbit');
            $table->year('tahun_terbit');
            $table->string('pengarang');
            $table->string('tempat_terbit')->nullable();
            $table->string('gmd')->nullable();
            $table->string('deskripsi_fisik');
            $table->string('judul_seri')->nullable();
            $table->string('judul');
            $table->string('edisi');
            $table->integer('nomor_panggil')->nullable();
            $table->string('bahasa');
            $table->integer('no_klas')->nullable();
            $table->string('keterangan')->default('ready');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukus');
    }
};
