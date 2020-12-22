<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCloseUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('close_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('guest_id')->comment('嘉宾ID');
            $table->string('unique_id', 10)->comment('唯一标识');
            $table->char('iso_code', 2);
            $table->string('idd_code', 5)->comment('国际区号');
            $table->string('username', 20)->comment('手机号');
            $table->string('we_chat', 20)->default('')->comment('微信号');
            $table->string('nickname', 32)->comment('昵称');
            $table->string('avatar', 200)->default('')->comment('头像');
            $table->unsignedTinyInteger('gender')->default(0)->comment('性别');
            $table->date('birthday')->nullable()->comment('生日');
            $table->string('note', 50)->default('')->comment('备注');
            $table->unsignedTinyInteger('status')->default(11)->comment('状态');
            $table->unsignedSmallInteger('login_count')->default(0)->comment('登录次数');
            $table->dateTime('last_login_at')->nullable()->comment('最近登录时间');
            $table->dateTime('registered_at')->comment('注册时间');
            $table->string('reason', 200)->default('')->comment('注销原因');
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
        Schema::dropIfExists('close_users');
    }
}
