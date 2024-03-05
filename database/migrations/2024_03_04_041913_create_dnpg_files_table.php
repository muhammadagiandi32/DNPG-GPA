<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDnpgFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dnpg_files', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('keterangan');
            $table->string('image_name');
            $table->string('url');
            $table->binary('image',16777215)->nullable();
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
        Schema::dropIfExists('dnpg_files');
    }
}
