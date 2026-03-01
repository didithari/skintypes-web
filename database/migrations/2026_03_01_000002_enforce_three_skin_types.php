<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('skin_types')) {
            return;
        }

        Schema::table('skin_types', function (Blueprint $table) {
            if (!Schema::hasColumn('skin_types', 'api_id')) {
                $table->unsignedTinyInteger('api_id')->nullable()->after('id');
            }
        });

        $mapping = [
            0 => 'dry',
            1 => 'normal',
            2 => 'oily',
        ];

        $targetIds = [];

        foreach ($mapping as $apiId => $name) {
            $existing = DB::table('skin_types')
                ->where('api_id', $apiId)
                ->orWhereRaw('LOWER(name) = ?', [$name])
                ->orWhereRaw('LOWER(name) = ?', [$name . ' skin'])
                ->orderBy('id')
                ->first();

            if ($existing) {
                DB::table('skin_types')
                    ->where('id', $existing->id)
                    ->update([
                        'api_id' => $apiId,
                        'name' => $name,
                        'updated_at' => now(),
                    ]);

                $targetIds[$apiId] = $existing->id;
            } else {
                $targetIds[$apiId] = DB::table('skin_types')->insertGetId([
                    'api_id' => $apiId,
                    'name' => $name,
                    'description' => 'Default skin type (' . $name . ')',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        $defaultTargetId = $targetIds[1] ?? reset($targetIds);

        $extraRows = DB::table('skin_types')
            ->whereNotIn('id', array_values($targetIds))
            ->get();

        foreach ($extraRows as $extraRow) {
            DB::table('products')
                ->where('skin_type_id', $extraRow->id)
                ->update(['skin_type_id' => $defaultTargetId]);

            DB::table('predictions')
                ->where('skin_type_id', $extraRow->id)
                ->update(['skin_type_id' => $defaultTargetId]);

            DB::table('skin_types')->where('id', $extraRow->id)->delete();
        }

        // Uniqueness on api_id is enforced by schema in fresh installs and by seeder constraints for existing data.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('skin_types')) {
            return;
        }

        Schema::table('skin_types', function (Blueprint $table) {
            if (Schema::hasColumn('skin_types', 'api_id')) {
                $table->dropColumn('api_id');
            }
        });
    }
};
