<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("grade_id")->nullable();
            $table->string("lesson");
            $table->date("date");
            $table->time("start");
            $table->time("end");
            $table->integer("salary_per_hour");
            $table->longText("video")->nullable();
            $table->longText("question")->nullable();
            $table->longText("teacher_comment")->nullable();
            $table->unsignedBigInteger("teacher_id");
            $table->foreign("grade_id")->references("id")->on("grades");
            $table->longText("students")->nullable();
            $table->string("attachments")->nullable();
            $table->string("origin")->default("bizsoft");
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
        Schema::dropIfExists('logs');
    }
};
