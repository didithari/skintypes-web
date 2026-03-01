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
        Schema::dropIfExists('skin_predictions');

        Schema::create('skin_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('api_id')->unique();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('skin_type_id')->constrained('skin_types')->cascadeOnDelete();
            $table->string('name');
            $table->string('brand')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('predictions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('skin_type_id')->constrained('skin_types')->cascadeOnDelete();
            $table->string('image_path')->nullable();
            $table->decimal('confidence', 5, 4)->nullable();
            $table->timestamp('predicted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('predictions');
        Schema::dropIfExists('products');
        Schema::dropIfExists('skin_types');
    }
};
