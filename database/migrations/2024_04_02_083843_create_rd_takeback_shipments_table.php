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
            $table->id('shipment_id');
            $table->string('trackback_type_store_customer_warehouse', 100)->nullable();
            $table->tinyInteger('asn')->default(0);
            $table->unsignedBigInteger('brand_id');
            $table->text('shipment_information_id')->nullable();
            $table->string('shipping_origin_zipcode', 150)->nullable();
            $table->string('shipping_carrier', 200)->nullable();
            $table->string('shipping_carrier_name', 200)->nullable();
            $table->string('box_type', 200)->nullable();
            $table->integer('quantity')->default(0);
            $table->string('total_weight', 150)->nullable();
            $table->tinyInteger('status')->default(0)->comment('0 for Unopened and 1 for open');
            $table->string('reviewd_by', 150)->nullable();
            $table->boolean('reviewe_by_manager')->default(false)->comment('1 for approved 0 for not approve');
            $table->timestamp('shipment_created_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
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
