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
            $table->id('product_id');
            $table->unsignedBigInteger('pallet_id');
            $table->unsignedBigInteger('shipment_id');
            $table->unsignedBigInteger('box_id');
            $table->unsignedBigInteger('brand_id');
            $table->string('box_packaging_weight')->nullable();
            $table->string('product_name');
            $table->decimal('product_weight', 10, 2)->default(0);
            $table->integer('product_quantity')->default(0);
            $table->string('product_category', 150)->nullable();
            $table->string('product_tier')->nullable();
            $table->string('good_resale_condition')->default(0);
            $table->timestamp('product_created_at')->useCurrent();
            $table->tinyInteger('status')->default(0)->comment('Status of the product (0: Inactive, 1: Active)');
            $table->string('reviewd_by')->nullable()->comment('Name of the reviewer');
            $table->boolean('reviewe_by_manager')->default(false)->comment('Indicates whether reviewed by manager');
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
