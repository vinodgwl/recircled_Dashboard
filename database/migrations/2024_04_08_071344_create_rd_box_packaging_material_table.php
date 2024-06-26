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
        Schema::create('rd_box_packaging_material', function (Blueprint $table) {
            $table->bigIncrements('box_packaging_id');
            $table->bigInteger('brand_id')->unsigned();
            $table->string('shipment_id');
            $table->bigInteger('pallet_id')->unsigned();
            $table->bigInteger('box_id')->unsigned();
            $table->string('material_type')->nullable();
            $table->decimal('material_weight', 10, 2)->default(0);
            $table->bigInteger('added_by')->unsigned();
            $table->bigInteger('updated_by')->unsigned();
            $table->string('approved_status');
            $table->bigInteger('approved_by')->unsigned();
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
        Schema::dropIfExists('rd_box_packaging_material');
    }
};
