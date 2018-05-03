<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceofshopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serviceofshops', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shopofinfos_id')->unsigned()->index();
            $table->foreign('shopofinfos_id')->references('id')->on('shopofinfos')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('serviceofcar_id')->unsigned()->index();
            $table->foreign('serviceofcar_id')->references('id')->on('serviceofcars')->onUpdate('cascade')->onDelete('cascade');
            $table->string('price')->nullable();
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
        Schema::dropIfExists('serviceofshops');
    }
}
