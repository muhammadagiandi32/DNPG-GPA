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
            $table->bigInteger('no')->unsigned()->nullable();
            $table->uuid('id')->primary();
            $table->foreignId('user_id');
            $table->string('dnpg_no');
            $table->string('group_name')->nullable();
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
