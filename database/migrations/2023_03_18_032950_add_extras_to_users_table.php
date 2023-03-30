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
        Schema::table('users', function (Blueprint $table) {
            $table->string("code")->nullable();
            $table->string("parent_phone")->nullable();
            $table->string("address")->nullable();
            $table->date("birthday")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn("code");
            $table->dropColumn("parent_phone");
            $table->dropColumn("address");
            $table->dropColumn("birthday");
        });
    }
};
