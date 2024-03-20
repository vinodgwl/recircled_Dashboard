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
        Schema::create('store_boxes', function (Blueprint $table) {
            $table->id();
            $table->string('box_unique_id', 255)->unique();
             $table->unsignedBigInteger('store_pallet_id');
            $table->string('pallet_unique_id', 255)->nullable();
            $table->text('shipment_id')->nullable();
            $table->decimal('box_weight', 10, 2)->nullable(); // Consider decimal for weight
            $table->string('product_category', 150)->nullable();
            $table->boolean('pre_consumer')->default(false);
            $table->timestamp('created_store_box_date_time')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->boolean('status')->default(false);
            $table->timestamps();

            // Foreign key constraint referencing store_pallets table
            $table->foreign('store_pallet_id')
                  ->references('id')
                  ->on('store_pallets')
                  ->onDelete('cascade'); // Adjust onDelete behavior if needed
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_boxes');
    }
};
