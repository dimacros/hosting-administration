<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHostingContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('hosting_contracts', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('customer_id')->unsigned();
        $table->integer('cpanel_account_id')->unsigned();
        $table->date('start_date');
        $table->date('finish_date');
        $table->decimal('total_price');
        $table->enum('status', 
          ['active', 'pending', 'canceled', 'finished', 'suspended']);
        $table->boolean('active');
        $table->integer('user_id')->unsigned();
        $table->timestamps();

        $table->foreign('customer_id')
              ->references('id')->on('customers')
              ->onDelete('cascade')->onUpdate('cascade');

        $table->foreign('cpanel_account_id')
              ->references('id')->on('cpanel_accounts')
              ->onDelete('cascade')->onUpdate('cascade');

        $table->foreign('user_id')
              ->references('id')->on('users')
              ->onDelete('cascade')->onUpdate('cascade');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hosting_contracts');
    }
}
