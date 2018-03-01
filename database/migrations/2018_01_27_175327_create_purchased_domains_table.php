<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasedDomainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchased_domains', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('acquired_domain_id')->unsigned();
            $table->integer('domain_provider_id')->unsigned();
            $table->integer('customer_id')->unsigned();
            $table->date('start_date');
            $table->date('finish_date');
            $table->decimal('total_price_in_dollars');
            $table->enum('status', 
              ['active', 'pending', 'canceled', 'finished', 'suspended']);
            $table->boolean('active');
            $table->integer('user_id')->unsigned();
            $table->timestamps();

            $table->foreign('acquired_domain_id')
                  ->references('id')->on('acquired_domains')
                  ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('domain_provider_id')
                  ->references('id')->on('domain_providers')
                  ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('customer_id')
                  ->references('id')->on('customers')
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
        Schema::dropIfExists('purchased_domains');
    }
}
