<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('parent_id')->nullable();
            $table->enum('url_target', ['_self', 'current'])->nullable()->default('_self');
            $table->string('url', 512)->nullable();
            $table->unsignedInteger('order_column')->nullable();
            $table->tinyInteger('publish_status')->default(0);
            $table->mediumText('config')->nullable();
            $table->integer('level')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
}
