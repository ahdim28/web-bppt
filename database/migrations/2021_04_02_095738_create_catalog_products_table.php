<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatalogProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalog_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('catalog_type_id')->nullable();
            $table->unsignedBigInteger('catalog_category_id')->nullable();
            $table->json('title');
            // $table->string('slug');
            $table->text('slug');
            $table->json('intro')->nullable();
            $table->json('content')->nullable();
            $table->integer('price')->nullable();
            $table->integer('quantity')->nullable();
            $table->boolean('is_discount')->default(false);
            $table->integer('discount')->nullable();
            $table->json('cover')->nullable();
            $table->json('banner')->nullable();
            $table->boolean('publish')->default(true);
            $table->boolean('public')->default(true);
            $table->boolean('is_detail')->default(true);
            $table->boolean('selection')->default(false);
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

            $table->foreign('catalog_type_id')->references('id')->on('catalog_types')
                ->onDelete('SET NULL');
            $table->foreign('catalog_category_id')->references('id')->on('catalog_categories')
                ->onDelete('SET NULL');
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
        Schema::dropIfExists('catalog_products');
    }
}
