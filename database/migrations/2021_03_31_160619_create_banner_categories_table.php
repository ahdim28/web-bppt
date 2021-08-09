<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannerCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banner_categories', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->json('description')->nullable();
            $table->integer('banner_limit')->nullable();
            $table->unsignedBigInteger('field_category_id')->nullable();
            $table->json('custom_field')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletesTz('deleted_at', 0);

            $table->foreign('field_category_id')->references('id')->on('field_categories')
                ->onDelete('SET NULL');
            $table->foreign('created_by')->references('id')->on('users')
                ->onDelete('SET NULL');
            $table->foreign('updated_by')->references('id')->on('users')
                ->onDelete('SET NULL');
            $table->foreign('deleted_by')->references('id')->on('users')
                ->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banner_categories');
    }
}
