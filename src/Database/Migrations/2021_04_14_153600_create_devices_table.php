<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('platform')->comment('平台');
            $table->string('device_id', 100)->comment('设备号');
            $table->string('system', 20)->comment('系统信息');
            $table->string('device_type', 20)->default('')->comment('设备类型');
            $table->string('device_name', 50)->comment('设备名');
            $table->boolean('is_baned')->comment('是否封停');
            $table->timestamps();

            $table->index('device_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('devices');
    }
}
