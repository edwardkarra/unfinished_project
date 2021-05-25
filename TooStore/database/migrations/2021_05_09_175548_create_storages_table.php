<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoragesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storages', function (Blueprint $table) {
            $table->id();
            $table->string('name')
                ->unique()
                ->nullable();
            $table->timestamps();
        });
        Schema::create('storage_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('storage_id');
            $table->unsignedBigInteger('user_id');
            $table->unique(['storage_id','user_id']);
            $table->timestamps();

            $table->foreign('storage_id')
                ->references('id')
                ->on('sotrages')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('storages');
    }
}
