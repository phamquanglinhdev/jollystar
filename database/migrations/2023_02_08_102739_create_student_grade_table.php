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
        Schema::create('student_grade', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("student_id");
            $table->foreign("student_id")->references("id")->on("users");
            $table->unsignedBigInteger("grade_id");
            $table->foreign("grade_id")->references("id")->on("grades");
            $table->date("start");
            $table->integer("pricing");
            $table->integer("current");
            $table->integer("promotion");
            $table->date("deadline")->nullable();
            $table->integer("payment");
            $table->integer("status");
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
        Schema::dropIfExists('student_grade');
    }
};
