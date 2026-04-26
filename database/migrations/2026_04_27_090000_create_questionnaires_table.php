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
        Schema::create('questionnaires', function (Blueprint $table) {
            $table->id();
            $table->foreignId('result_id')->unique()->constrained('predictions')->cascadeOnDelete();
            $table->boolean('q1_is_smooth');
            $table->unsignedTinyInteger('q2_rating');
            $table->string('q3_match_status', 20);
            $table->string('expected_skin')->nullable();
            $table->boolean('q4_has_used_recommended_product');
            $table->boolean('q5_ingredient_info_clear');
            $table->boolean('q6_helpful_for_new_product');
            $table->boolean('q7_would_click_buy_button');
            $table->boolean('consent');
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questionnaires');
    }
};
