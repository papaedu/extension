<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Begin\Database\Migrations\BeginMigration;

class CreateGuestDevicesTable extends BeginMigration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guest_device', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('guest_id')->comment('嘉宾ID');
            $table->unsignedBigInteger('device_id')->comment('设备ID');
            $table->timestamps();

            $table->index('guest_id');
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
        Schema::dropIfExists('guest_device');
    }
}
