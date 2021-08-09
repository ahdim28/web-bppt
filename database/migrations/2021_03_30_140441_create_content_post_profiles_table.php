<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentPostProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_post_profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id');
            $table->json('fields');
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
        Schema::dropIfExists('content_post_profiles');
    }
}
