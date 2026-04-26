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
        if (!Schema::hasColumn('predictions', 'is_skin_type_correct')) {
            Schema::table('predictions', function (Blueprint $table) {
                $table->boolean('is_skin_type_correct')->nullable();
            });
        }

        if (!Schema::hasColumn('predictions', 'expected_skin')) {
            Schema::table('predictions', function (Blueprint $table) {
                $table->string('expected_skin')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $columnsToDrop = [];

        if (Schema::hasColumn('predictions', 'is_skin_type_correct')) {
            $columnsToDrop[] = 'is_skin_type_correct';
        }

        if (Schema::hasColumn('predictions', 'expected_skin')) {
            $columnsToDrop[] = 'expected_skin';
        }

        if (!empty($columnsToDrop)) {
            Schema::table('predictions', function (Blueprint $table) use ($columnsToDrop) {
                $table->dropColumn($columnsToDrop);
            });
        }
    }
};
