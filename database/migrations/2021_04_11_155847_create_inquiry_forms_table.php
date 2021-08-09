<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInquiryFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inquiry_forms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inquiry_id');
            $table->ipAddress('ip_address');
            $table->json('fields')->nullable();
            $table->boolean('status')->default(false);
            $table->boolean('exported')->default(false);
            $table->timestamp('submit_time');
            $table->softDeletesTz('deleted_at', 0);

            $table->foreign('inquiry_id')->references('id')->on('inquiries')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inquiry_forms');
    }
}
