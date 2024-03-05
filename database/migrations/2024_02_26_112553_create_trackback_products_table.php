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
        Schema::create('trackback_products', function (Blueprint $table) {
            $table->id();
            $table->string('trackback_product_type', 100)->nullable();
            $table->boolean('asn')->default(false);
            $table->unsignedBigInteger('brand_id');
            $table->text('shipment_id')->nullable();
            $table->integer('quantity')->default(0);
            $table->string('total_weight', 100)->nullable();
            $table->json('products')->nullable();
            $table->timestamps();
            // Foreign key constraint
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trackback_products');
    }
};
