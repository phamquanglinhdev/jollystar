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
        Schema::create('staff_task', function (Blueprint $table) {
            $table->unsignedBigInteger("staff_id");
            $table->unsignedBigInteger("task_id");
            $table->foreign("staff_id")->references("id")->on("users");
            $table->foreign("task_id")->references("id")->on("tasks");
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
        Schema::dropIfExists('staff_task');
    }
};
