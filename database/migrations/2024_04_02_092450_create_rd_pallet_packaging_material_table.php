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
            $table->id();
            $table->unsignedBigInteger('shipment_id');
            $table->unsignedBigInteger('pallet_id');
            $table->string('material_type', 200)->nullable();
            $table->decimal('material_weight', 10, 2)->nullable();
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
