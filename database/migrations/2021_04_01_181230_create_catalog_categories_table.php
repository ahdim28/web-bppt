<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatalogCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalog_categories', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->string('slug')->unique();
            $table->json('description')->nullable();
            $table->json('cover')->nullable();
            $table->json('banner')->nullable();
            $table->boolean('is_detail')->default(true);
            $table->integer('product_limit')->nullable();
            $table->integer('product_selection')->nullable();
            $table->unsignedBigInteger('custom_view_id')->nullable();
            $table->json('meta_data')->nullable();
            $table->unsignedBigInteger('field_category_id')->nullable();
            $table->json('custom_field')->nullable();
            $table->bigInteger('viewer')->default(0);
            $table->integer('position')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletesTz('deleted_at', 0);

            $table->foreign('custom_view_id')->references('id')->on('templates')
                ->onDelete('SET NULL');
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
        Schema::dropIfExists('catalog_categories');
    }
}
