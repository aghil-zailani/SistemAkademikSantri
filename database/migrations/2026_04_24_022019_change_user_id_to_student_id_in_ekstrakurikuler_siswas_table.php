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
        Schema::table('ekstrakurikuler_siswas', function (Blueprint $table) {
            // Drop old FK dan kolom user_id
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            
            // Tambah student_id yang merujuk ke tabel students
            $table->foreignId('student_id')
                  ->after('ekstrakurikuler_id')
                  ->constrained('students')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ekstrakurikuler_siswas', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
            $table->dropColumn('student_id');
            
            $table->foreignId('user_id')
                  ->after('ekstrakurikuler_id')
                  ->constrained('users')
                  ->onDelete('cascade');
        });
    }
};
