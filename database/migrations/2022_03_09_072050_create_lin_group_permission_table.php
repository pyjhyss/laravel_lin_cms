<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinGroupPermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lin_group_permission', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('group_id')->comment('分组id');
            $table->unsignedInteger('permission_id')->comment('权限id');

            $table->index(['group_id', 'permission_id'], 'group_id_permission_id');
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `lin_group_permission` COMMENT '角色权限表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lin_group_permission');
    }
}
