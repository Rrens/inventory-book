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
            $table->integer('nomor_panggil');
            $table->string('bahasa');
            $table->integer('no_klas');
            $table->string('keterangan');
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
