<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->string('item_id')
                ->nullable()
                ->unique();
            $table->unsignedBigInteger('storage_id');


            $table->string('name');
            $table->json('info')->nullable();
            $table->string('created_by')->default('user');
            $table->timestamps();

            $table->foreign('storage_id')
                ->references('id')
                ->on('storages')
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
        Schema::dropIfExists('items');
    }
}
