<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lin_log', function (Blueprint $table) {
            $table->increments('id');
            $table->string('message', 450)->nullable();
            $table->unsignedInteger('user_id');
            $table->string('username', 24)->nullable();
            $table->string('method', 20)->nullable();
            $table->string('path', 50)->nullable();
            $table->string('permission', 100)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lin_log');
    }
}
