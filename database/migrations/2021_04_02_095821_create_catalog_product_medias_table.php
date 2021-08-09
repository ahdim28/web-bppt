<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatalogProductMediasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalog_product_medias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('catalog_product_id');
            $table->boolean('is_video')->default(false);
            $table->boolean('is_youtube')->default(false);
            $table->text('file')->nullable();
            $table->text('thumbnail')->nullable();
            $table->text('youtube_id')->nullable();
            $table->json('caption')->nullable();
            $table->integer('position');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletesTz('deleted_at', 0);

            $table->foreign('catalog_product_id')->references('id')->on('catalog_products')
                ->cascadeOnDelete();
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
        Schema::dropIfExists('catalog_product_medias');
    }
}
