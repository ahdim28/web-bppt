<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('menu_category_id');
            $table->integer('parent')->nullable();
            $table->json('title')->nullable();
            $table->integer('module')->nullable();
            $table->json('attr')->nullable();
            $table->boolean('publish')->default(1);
            $table->boolean('public')->default(1);
            $table->boolean('edit_public_menu')->default(0);
            $table->bigInteger('menuable_id')->nullable();
            $table->string('menuable_type')->nullable();
            $table->integer('position')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletesTz('deleted_at', 0);

            $table->foreign('menu_category_id')->references('id')->on('menu_categories')
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
        Schema::dropIfExists('menus');
    }
}
