<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('replies', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('ticket_id')->unsigned();
          $table->integer('user_id')->unsigned()->nullable();
          $table->text('content');
          $table->text('attached_files')->nullable();
          $table->timestamps();

          $table->foreign('ticket_id')
                ->references('id')->on('tickets')
                ->onUpdate('cascade')->onDelete('cascade');

          $table->foreign('user_id')
                ->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');

      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('replies');
    }
}
