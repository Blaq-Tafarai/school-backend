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
        Schema::table('resources', function (Blueprint $table) {
            if (!Schema::hasColumn('resources', 'admin_id')) {
                $table->unsignedBigInteger('teacher_id')->nullable()->change();
                $table->foreignId('admin_id')->nullable()->constrained('users')->onDelete('cascade')->after('teacher_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('resources', function (Blueprint $table) {
            $table->dropForeign(['resources_admin_id_foreign']);
            $table->dropColumn('admin_id');
            $table->unsignedBigInteger('teacher_id')->change();
        });
    }
};
