<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnonIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anon_issues', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->enum('status', ['open', 'inprogress', 'resolved', 'closed'])->default('open');
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('region_id');
            $table->unsignedBigInteger('district_id');
            $table->unsignedBigInteger('ward_id');
            $table->unsignedBigInteger('street_id');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('file_path')->nullable();
            $table->string('code')->unique();
            $table->boolean('citizen_satisfied')->nullable();
            $table->unsignedBigInteger('sealed_by')->nullable();
            $table->unsignedBigInteger('to_user_id')->nullable();
            $table->unsignedBigInteger('read')->nullable();
            $table->boolean('visibility')->default(0); // 0 or 1, default is 0
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('anon_issues');
    }
}
