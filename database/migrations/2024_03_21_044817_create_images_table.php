<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->bigInteger('no')->unsigned()->nullable();
            $table->uuid('id')->primary(); // Menjadikan kolom 'id' sebagai primary key
            $table->uuid('image_id');
            $table->string('keterangan');
            $table->string('image_name');
            $table->string('url');
            $table->timestamps();

            $table->foreign('image_id')->references('id')->on('dnpg_files')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('images');
    }
}
