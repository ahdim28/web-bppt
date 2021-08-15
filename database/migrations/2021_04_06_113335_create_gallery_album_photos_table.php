<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGalleryAlbumPhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gallery_album_photos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('album_id');
            $table->text('file');
            $table->string('file_type')->comment('Mime Type');
            $table->bigInteger('file_size')->comment('Byte');
            $table->json('title')->nullable();
            $table->json('description')->nullable();
            $table->text('alt')->nullable();
            $table->integer('position');
            $table->boolean('flags')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletesTz('deleted_at', 0);

            $table->foreign('album_id')->references('id')->on('gallery_albums')
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
        Schema::dropIfExists('gallery_album_photos');
    }
}
