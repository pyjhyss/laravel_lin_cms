<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lin_user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 24)->comment('用户名，唯一');
            $table->string('nickname', 24)->nullable()->comment('用户昵称');
            $table->string('password')->comment('密码');
            $table->string('avatar', 500)->nullable()->comment('头像url');
            $table->string('email', 100)->nullable()->comment('邮箱');
            $table->boolean('is_admin')->default(false)->comment('是否管理员');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['username', 'deleted_at'], 'username_del');
            $table->unique(['email', 'deleted_at'], 'email_del');
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `lin_user` COMMENT '用户表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lin_user');
    }
}
