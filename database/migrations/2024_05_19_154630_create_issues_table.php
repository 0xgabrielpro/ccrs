<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issues', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('title', 255);
            $table->text('description');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->enum('status', ['open', 'inprogress', 'resolved', 'closed'])->default('open');
            $table->boolean('citizen_satisfied')->nullable();
            $table->unsignedBigInteger('sealed_by')->nullable();
            $table->unsignedBigInteger('to_user_id')->nullable();
            $table->unsignedBigInteger('read')->nullable();
            $table->string('file_path')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            if (Schema::hasTable('categories')) {
                $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            }
            if (Schema::hasTable('users')) {
                $table->foreign('sealed_by')->references('id')->on('users')->onDelete('set null');
                $table->foreign('to_user_id')->references('id')->on('users')->onDelete('set null');
            }
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('issues');
    }
}
