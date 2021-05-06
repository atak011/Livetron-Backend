<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name',100);
            $table->string('slug',100);
            $table->double('price');
            $table->string('image')->nullable();
            $table->string('video')->nullable();
            $table->string('3d_and')->nullable();
            $table->string('3d_ios')->nullable();
            $table->jsonb('conf')->nullable();
            $table->jsonb('attributes');
            $table->string('label');
            $table->string('brand');
            $table->string('category');
            $table->integer('omnitron_id');
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
        Schema::dropIfExists('products');
    }
}
