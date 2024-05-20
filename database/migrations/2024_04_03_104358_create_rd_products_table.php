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
        Schema::create('rd_products', function (Blueprint $table) {
           $table->bigIncrements('box_product_id');
            $table->unsignedBigInteger('brand_id');
            $table->unsignedBigInteger('shipment_id');
            $table->unsignedBigInteger('pallet_id');
            $table->unsignedBigInteger('box_id');
            $table->unsignedBigInteger('product_category')->nullable();
            $table->unsignedBigInteger('product_type');
            $table->decimal('product_weight', 10, 2)->default(0);
            $table->integer('product_quantity')->default(0);
            $table->unsignedBigInteger('product_tier')->nullable();
            $table->string('good_resale_condition')->default('0');
            $table->unsignedBigInteger('added_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->string('approved_status')->nullable();
            $table->boolean('approved_by')->default(0);
            $table->timestamps();

            // Define foreign key constraint
            $table->foreign('box_id')->references('box_id')->on('rd_boxes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rd_products');
    }
};
