<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->json('title');
            $table->text('slug');
            $table->json('description')->nullable();
            $table->boolean('from')->default(false);
            $table->text('file')->nullable();
            $table->string('file_type')->nullable()->comment('Mime Type');
            $table->bigInteger('file_size')->nullable()->comment('Byte');
            $table->text('document_url')->nullable();
            $table->json('cover')->nullable();
            $table->boolean('publish')->default(true);
            $table->boolean('public')->default(true);
            $table->integer('position')->nullable();
            $table->bigInteger('download')->default(0);
            $table->bigInteger('viewer')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletesTz('deleted_at', 0);

            $table->foreign('category_id')->references('id')->on('document_categories')
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
        Schema::dropIfExists('documents');
    }
}
