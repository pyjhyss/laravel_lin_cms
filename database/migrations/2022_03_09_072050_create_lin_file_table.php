<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lin_file', function (Blueprint $table) {
            $table->increments('id');
            $table->string('path', 500);
            $table->string('type', 10)->default('LOCAL')->comment('LOCAL 本地，REMOTE 远程');
            $table->string('name', 100);
            $table->string('extension', 50)->nullable();
            $table->integer('size')->nullable();
            $table->string('md5', 40)->nullable()->unique('md5_del')->comment('md5值，防止上传重复文件');
            $table->softDeletes()->comment('软删除');
            $table->timestamps();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `lin_file` COMMENT '文件表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lin_file');
    }
}
