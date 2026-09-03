<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Rename 'nip' kembali ke 'email' jika sebelumnya sempat di-rename
        if (!Schema::hasColumn('users', 'email') && Schema::hasColumn('users', 'nip')) {
            Schema::table('users', function (Blueprint $table) {
                $table->renameColumn('nip', 'email');
            });
        }

        // 2. Tambahkan kolom 'nip' baru
        if (!Schema::hasColumn('users', 'nip')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('nip')->nullable()->unique()->after('name');
            });
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'nip')) {
                $table->dropColumn('nip');
            }
        });
    }
};  