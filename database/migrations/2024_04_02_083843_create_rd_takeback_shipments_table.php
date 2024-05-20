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
        Schema::create('rd_takeback_shipments', function (Blueprint $table) {
            $table->bigIncrements('shipment_id');
            $table->string('takeback_id')->nullable();
            $table->tinyInteger('is_asn')->nullable()->default(0);
            $table->bigInteger('asn_id');
            $table->bigInteger('brand_id');
            $table->text('shipment_information_id');
            $table->string('shipping_origin_zipcode', 150)->nullable();
            $table->string('shipping_carrier', 200)->nullable();
            $table->bigInteger('shipping_career_id')->nullable();
            $table->string('shipment_type', 200)->nullable();
            $table->integer('pallet_qty')->default(0);
            $table->string('total_weight', 200);
            $table->string('shipment_tracking_code', 255);
            $table->string('shipment_tracking_URL', 255);
            $table->bigInteger('added_by')->unsigned();
            $table->bigInteger('updated_by')->unsigned();
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('approved_status')->default(0);
            $table->bigInteger('approved_by');
            $table->dateTime('shipment_created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('shipment_updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rd_takeback_shipments');
    }
};
