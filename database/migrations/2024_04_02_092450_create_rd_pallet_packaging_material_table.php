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
        Schema::create('rd_pallet_packaging_material', function (Blueprint $table) {
           $table->bigIncrements('packaging_material_id');
            $table->string('shipment_id');
            $table->bigInteger('pallet_id')->unsigned();
            $table->string('material_type')->nullable();
            $table->decimal('material_weight', 10, 2)->default(0);
            $table->string('approved_status');
            $table->bigInteger('added_by')->unsigned();
            $table->bigInteger('updated_by')->unsigned();
            $table->bigInteger('approved_by');
            $table->timestamps();
            $table->foreign('pallet_id')->references('pallet_id')->on('rd_pallets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rd_pallet_packaging_material');
    }
};
