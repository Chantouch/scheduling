<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJsonDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('json_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('iCalUID');
            $table->longText('data_json')->nullable();
            $table->string('created')->nullable();
            $table->string('updated')->nullable();
            $table->string('htmlLink')->nullable();
            $table->string('location')->nullable();
            $table->string('status')->nullable();
            $table->longText('summary')->nullable();
            $table->longText('creator')->nullable();
            $table->longText('organizer')->nullable();
            $table->string('start')->nullable();
            $table->string('end')->nullable();
            $table->integer('user_id', false, true)->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('json_datas');
    }
}
