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
        Schema::create('rd_boxes', function (Blueprint $table) {
            $table->bigIncrements('box_id');
            $table->bigInteger('brand_id')->unsigned();
            $table->bigInteger('shipment_id')->unsigned()->nullable();
            $table->bigInteger('pallet_id')->unsigned();
            $table->string('box_code');
            $table->decimal('box_weight', 10, 2)->default(0);
            $table->string('product_category')->nullable();
            $table->string('consumer')->default('0'); // Changed column name to 'consumer' as 'Post/Pre' is not recommended
            $table->tinyInteger('status')->default(0); // Changed column name to 'status'
            $table->bigInteger('added_by')->unsigned();
            $table->bigInteger('updated_by')->unsigned();
            $table->string('approved_status')->nullable();
            $table->tinyInteger('approved_by')->default(0);
            $table->timestamps();
            
            // Foreign key constraint
            $table->foreign('pallet_id')->references('pallet_id')->on('rd_pallets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rd_boxes');
    }
};
