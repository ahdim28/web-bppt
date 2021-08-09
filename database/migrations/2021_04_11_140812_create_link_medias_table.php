<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinkMediasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('link_medias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('link_id');
            $table->json('title');
            $table->json('description')->nullable();
            $table->text('url');
            $table->json('cover')->nullable();
            $table->json('banner')->nullable();
            $table->unsignedBigInteger('field_category_id')->nullable();
            $table->json('custom_field')->nullable();
            $table->integer('position')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletesTz('deleted_at', 0);

            $table->foreign('link_id')->references('id')->on('links')
                ->cascadeOnDelete();
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
        Schema::dropIfExists('link_medias');
    }
}
