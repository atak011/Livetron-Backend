<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventRefsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_refs', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('image')->nullable();
            $table->string('name',50);
            $table->boolean('promote')->default(true);
            $table->bigInteger('event_id');
            $table->bigInteger('participation')->default(0);
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
        Schema::dropIfExists('event_refs');
    }
}
