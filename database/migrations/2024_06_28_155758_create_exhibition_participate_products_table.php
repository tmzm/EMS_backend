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
        Schema::create('exhibition_participate_products', function (Blueprint $table) {
            $table->id();
            $table->double('quantity');
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('exhibition_participate_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exhibition_participate_products');
    }
};
