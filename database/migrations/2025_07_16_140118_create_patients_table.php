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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama pasien
            $table->string('gender'); // Jenis Kelamin
            $table->date('date_of_birth'); // Tanggal lahir
            $table->text('address'); // Alamat
            $table->string('phone_number'); // Nomor telepon
            $table->string('NIK'); // Nomor Induk Keluarga
            $table->string('photo')->nullable(); // Foto
            $table->timestamps(); // Kolom created_at dan updated_at (otomatis)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
