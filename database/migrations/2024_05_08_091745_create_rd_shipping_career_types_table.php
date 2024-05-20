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
        Schema::create('rd_shipping_career_types', function (Blueprint $table) {
            $table->bigIncrements('shipping_career_id');
            $table->bigInteger('brand_id');
            $table->string('shipping_name');
            $table->bigInteger('added_by')->unsigned();
            $table->bigInteger('updated_by')->unsigned();
            $table->timestamps();
             // Define foreign key constraints if needed
            // $table->foreign('brand_id')->references('id')->on('brands');
            // $table->foreign('added_by')->references('id')->on('users');
            // $table->foreign('updated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rd_shipping_career_types');
    }
};
