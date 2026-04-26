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
        Schema::create('skin_type_ingredients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('skin_type_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['good', 'bad']);
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skin_type_ingredients');
    }
};
