<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaLibrariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_libraries', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['image', 'file', 'video', 'audio'])->comment('文件类型');
            $table->string('url', 100)->comment('地址');
            $table->char('md5', 32);
            $table->unsignedSmallInteger('height')->default(0)->comment('高');
            $table->unsignedSmallInteger('width')->default(0)->comment('宽');
            $table->unsignedInteger('size')->default(0)->comment('大小');
            $table->unsignedTinyInteger('status')->default(1)->comment('状态');
            $table->string('scan_task_id', 50)->default('')->comment('检测任务ID');
            $table->unsignedTinyInteger('scan_result')->default(0)->comment('检测结果');
            $table->morphs('model');
            $table->timestamps();

            $table->index('url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media_libraries');
    }
}
