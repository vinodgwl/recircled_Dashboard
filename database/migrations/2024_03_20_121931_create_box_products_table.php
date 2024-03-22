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
        Schema::create('box_products', function (Blueprint $table) {
            $table->id();
            $table->integer('store_pallet_id');
            $table->unsignedBigInteger('store_box_id');
            $table->text('shipment_id')->nullable();
            $table->string('product_name')->nullable();
            $table->string('product_weight')->nullable();
            $table->integer('product_quantity');
            $table->string('product_tier')->nullable();
            $table->string('good_resale_condition')->nullable();
            $table->timestamp('created_box_product_date_time')->nullable()->default(now());
            $table->boolean('status')->default(false);
            $table->timestamps();

            // Define foreign key
            
            $table->foreign('store_box_id')->references('id')->on('store_boxes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('box_products');
    }
};
