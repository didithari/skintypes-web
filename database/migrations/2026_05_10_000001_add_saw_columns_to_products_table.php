<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Adds SAW (Simple Additive Weighting) criteria columns to products table.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // C1: Kandungan aktif (Benefit) - 1=Rendah, 2=Sedang, 3=Tinggi, 4=Sangat Tinggi
            $table->unsignedTinyInteger('c1_kandungan')->default(1)->after('image_url');
            // C2: Kandungan iritatif/Alkohol,Paraben,Fragrance (Cost) - 1=Rendah, 2=Sedang, 3=Tinggi
            $table->unsignedTinyInteger('c2_iritatif')->default(1)->after('c1_kandungan');
            // C3: Harga (Cost) - 1=<50rb, 2=50-100rb, 3=100-150rb, 4=>150rb
            $table->unsignedTinyInteger('c3_harga')->default(1)->after('c2_iritatif');
            // C4: Tekstur (Benefit) - gel, foam, cream
            $table->enum('c4_tekstur', ['gel', 'foam', 'cream'])->default('foam')->after('c3_harga');
            // Link menuju toko resmi produk
            $table->string('link_produk')->nullable()->after('c4_tekstur');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['c1_kandungan', 'c2_iritatif', 'c3_harga', 'c4_tekstur', 'link_produk']);
        });
    }
};
