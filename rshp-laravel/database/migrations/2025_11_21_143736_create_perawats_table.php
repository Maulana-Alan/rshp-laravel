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
        Schema::create('perawats', function (Blueprint $table) {
            // Primary Key custom: id_perawat
            $table->id('id_perawat'); 
            
            // Data diri sesuai modul
            $table->string('alamat', 100);
            $table->string('no_hp', 45);
            $table->string('jenis_kelamin', 1);
            $table->string('pendidikan', 100); // Khusus perawat ada pendidikan
            
            // Relasi ke user
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perawats');
    }
};