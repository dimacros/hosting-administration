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
        $table->unsignedInteger('customer_id');
        $table->unsignedInteger('hosting_plan_contracted_id');
        $table->date('start_date');
        $table->date('finish_date');
        $table->decimal('total_price');
        $table->enum('status', 
          ['active', 'pending', 'canceled', 'finished', 'suspended']);
        $table->unsignedSmallInteger('notifications_sent')->default(0);
        $table->boolean('is_active')->comment('Yes, it is the last contract purchased by the client');
        $table->unsignedInteger('user_id')->nullable();
        $table->timestamps();

        $table->foreign('customer_id')
              ->references('id')->on('customers')
              ->onUpdate('cascade')->onDelete('cascade');

        $table->foreign('hosting_plan_contracted_id')
              ->references('id')->on('hosting_plans_contracted')
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
        Schema::dropIfExists('hosting_contracts');
    }
}
