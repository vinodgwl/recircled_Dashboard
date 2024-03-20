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
        Schema::create('store_pallets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tackback_store_id');
            $table->string('pallet_unique_id', 255)->unique();
            $table->string('store_sub_brand', 200)->nullable();
            $table->decimal('pallet_weight', 10, 2)->nullable(); // Consider decimal instead of VARCHAR
            $table->text('shipment_id')->nullable();
            $table->timestamp('created_store_shipment_date_time')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->boolean('status')->default(false);
            $table->text('pallet_packaging_material')->nullable();
            $table->integer('box_quantity')->default(0);
            $table->timestamps();

            // Foreign key with corrected column name and data type
            
            $table->foreign('tackback_store_id')
                  ->references('id')
                  ->on('tackback_stores')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_pallets');
    }
};
