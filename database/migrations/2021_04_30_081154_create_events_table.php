<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name',100);
            $table->string('slug',100);
            $table->dateTime('start_date');
            $table->dateTime('estimated_end_date')->nullable();
            $table->integer('estimated_visitor')->default(0);
            $table->integer('visitor_limit')->default(0);
            $table->string('client_group')->nullable();
            $table->string('provider')->default('twillio');
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('events');
    }
}
