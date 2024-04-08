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
            $table->id('box_id');
            $table->unsignedBigInteger('pallet_id');
            $table->unsignedBigInteger('shipment_id');
            $table->string('box_gen_code')->unique();
            $table->string('pallet_gen_code');
            $table->unsignedBigInteger('brand_id');
            $table->decimal('box_weight', 10, 2)->default(0);
            $table->string('product_category', 150)->default(0);
            $table->tinyInteger('pre_consumer')->default(0);
            $table->timestamp('box_created_at')->useCurrent();
            $table->tinyInteger('status')->default(0)->comment('Status of the box (0: Unopened, 1: Opened)');
            $table->string('reviewd_by')->nullable()->comment('Name of the reviewer');
            $table->boolean('reviewe_by_manager')->default(false)->comment('Indicates whether reviewed by manager');
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
