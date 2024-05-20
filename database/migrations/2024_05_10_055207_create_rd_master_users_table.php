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
        Schema::create('rd_master_users', function (Blueprint $table) {
            $table->bigIncrements('user_id');
            $table->string('user_name');
            $table->string('user_email');
            $table->string('user_password');
            $table->bigInteger('user_role_id');
            $table->bigInteger('details_send_email_status');
            $table->bigInteger('active_status');
            $table->bigInteger('added_by')->unsigned();
            $table->bigInteger('updated_by')->unsigned();
            $table->timestamp('recent_login_time')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rd_master_users');
    }
};
