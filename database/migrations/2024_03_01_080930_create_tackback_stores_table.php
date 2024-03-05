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
        Schema::create('tackback_stores', function (Blueprint $table) {
            $table->id();
            $table->string('trackback_product_store_type', 100)->nullable();
            $table->boolean('asn')->default(false);
            $table->unsignedBigInteger('brand_id');
            $table->text('shipment_id')->nullable();
            $table->string('shipping_origin_zipcode', 150)->nullable();
            $table->string('shipping_carrier', 200)->nullable();
            $table->string('shipping_carrier_name', 200)->nullable();
            $table->string('type', 200)->nullable();
            $table->integer('quantity')->default(0);
            $table->string('total_weight', 100)->nullable();
            $table->string('pallet_unique_id')->unique();
            $table->timestamp('created_store_date_time')->nullable()->default(now());
            $table->string('store_sub_brand', 200)->nullable();
            $table->string('pallet_weight', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tackback_stores');
    }
};
