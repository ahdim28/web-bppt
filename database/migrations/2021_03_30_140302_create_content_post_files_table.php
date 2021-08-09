<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentPostFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_post_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id');
            $table->string('file');
            $table->string('file_type')->comment('Mime Type');
            $table->bigInteger('file_size')->comment('Byte');
            $table->json('caption')->nullable();
            $table->timestamps();

            $table->foreign('post_id')->references('id')->on('content_posts')
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
        Schema::dropIfExists('content_post_files');
    }
}
