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
        Schema::create('rd_pallets', function (Blueprint $table) {
           $table->id('pallet_id');
            $table->unsignedBigInteger('shipment_id');
            $table->string('pallet_gen_code', 255)->unique();
            $table->unsignedBigInteger('brand_id');
            $table->string('sub_brand', 200)->nullable();
            $table->decimal('pallet_weight', 10, 2)->nullable();
            $table->integer('box_quantity')->default(0);
            $table->timestamp('pallet_created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->tinyInteger('status')->default(0)->comment('0 for Unopened and 1 for open');
            $table->string('reviewd_by', 255)->nullable();
            $table->boolean('reviewe_by_manager')->default(false);
            $table->timestamps();
            $table->foreign('shipment_id')->references('shipment_id')->on('rd_takeback_shipments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rd_pallets');
    }
};
