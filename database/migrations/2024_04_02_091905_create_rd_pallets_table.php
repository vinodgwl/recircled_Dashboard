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
           $table->bigIncrements('pallet_id');
            $table->bigInteger('shipment_id')->unsigned();
            $table->bigInteger('brand_id')->unsigned();
            $table->string('pallet_code', 255);
            $table->decimal('pallet_weight', 10, 2)->nullable();
            $table->integer('box_count')->default(0);
            $table->timestamp('pallet_created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->tinyInteger('approved_status')->default(0);
            $table->bigInteger('approved_by');
            $table->bigInteger('added_by')->unsigned();
            $table->bigInteger('updated_by')->unsigned();
            $table->tinyInteger('status')->default(0);
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
