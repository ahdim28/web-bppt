<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('section_id');
            $table->integer('parent')->default(0);
            $table->json('name');
            $table->string('slug');
            $table->json('description')->nullable();
            $table->boolean('public')->default(true);
            $table->boolean('is_detail')->default(false);
            $table->unsignedBigInteger('list_view_id')->nullable();
            $table->unsignedBigInteger('detail_view_id')->nullable();
            $table->string('list_limit')->nullable();
            $table->json('banner')->nullable();
            $table->unsignedBigInteger('field_category_id')->nullable();
            $table->json('custom_field')->nullable();
            $table->integer('position');
            $table->bigInteger('viewer')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletesTz('deleted_at', 0);

            $table->foreign('section_id')->references('id')
                ->on('content_sections')->cascadeOnDelete();
            $table->foreign('list_view_id')->references('id')->on('templates')
                ->onDelete('SET NULL');
            $table->foreign('detail_view_id')->references('id')->on('templates')
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
        Schema::dropIfExists('content_categories');
    }
}
