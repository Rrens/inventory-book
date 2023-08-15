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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('email')->nullable();
            $table->string('gender');
            $table->text('alamat');
            $table->string('nama_instansi')->nullable();
            $table->string('image')->nullable();
            $table->text('phone');
            $table->string('kode_pos');
            $table->string('type_anggota')->nullable();
            $table->string('jenis_user');
            $table->date('tanggal_lahir');
            $table->date('tanggal_input');
            $table->string('password');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
