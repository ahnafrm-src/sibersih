<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Jika kolom email belum ada / berganti nama sebelumnya
            if (!Schema::hasColumn('users', 'email')) {
                $table->renameColumn('nip', 'email');
            }
            
            // Tambahkan kolom nip (nullable karena admin tidak wajib punya NIP)
            if (!Schema::hasColumn('users', 'nip')) {
                $table->string('nip')->nullable()->unique()->after('name');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('nip');
        });
    }
};