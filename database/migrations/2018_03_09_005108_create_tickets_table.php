<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('tickets', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('help_topic_id')->unsigned()->nullable();
          $table->integer('user_id')->unsigned();
          $table->string('subject');
          $table->enum('status', ['open', 'closed'] );
          $table->boolean('solved');
          $table->timestamps();

          $table->foreign('help_topic_id')
                ->references('id')->on('help_topics')
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
        Schema::dropIfExists('tickets');
    }
}
