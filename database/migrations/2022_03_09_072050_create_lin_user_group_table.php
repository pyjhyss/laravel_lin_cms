<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateLinUserGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lin_user_group', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->comment('用户id');
            $table->unsignedInteger('group_id')->comment('分组id');

            $table->index(['user_id', 'group_id'], 'user_id_group_id');
        });
        DB::statement("ALTER TABLE `lin_user_group` COMMENT '用户角色表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lin_user_group');
    }
}
