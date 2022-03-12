<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lin_group', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 60)->unique('name_del')->comment('分组名称，例如：搬砖者');
            $table->string('info')->nullable()->comment('分组信息：例如：搬砖的人');
            $table->softDeletes()->comment('软删除');
            $table->timestamps();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `lin_group` COMMENT '角色表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lin_group');
    }
}
