<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateLinPermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lin_permission', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 60)->comment('权限名称，例如：访问首页');
            $table->string('module', 50)->comment('权限所属模块，例如：人员管理');
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement("ALTER TABLE `lin_permission` COMMENT '权限表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lin_permission');
    }
}
