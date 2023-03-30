<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->integer("value");
            $table->string("origin")->default("bizsoft");
            $table->date("date");
            $table->unsignedBigInteger("staff_id")->nullable();
            $table->unsignedBigInteger("accept_id")->nullable();
            $table->foreign("staff_id")->references("id")->on("users")->cascadeOnDelete();
            $table->foreign("accept_id")->references("id")->on("users")->cascadeOnDelete();
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
        Schema::dropIfExists('payments');
    }
};
