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
            $table->integer('customer_id')->unsigned();
            $table->integer('domain_provider_id')->unsigned();
            $table->string('domain_name')->unique();
            $table->decimal('total_price_in_dollars');
            $table->text('domain_description')->nullable();
            $table->date('start_date');
            $table->date('finish_date');
            $table->enum('status', 
              ['active', 'pending', 'canceled', 'finished', 'suspended']);
            $table->boolean('is_active')->comment('Yes, it is the last domain purchased by the client');
            $table->integer('user_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('customer_id')
                  ->references('id')->on('customers')
                  ->onUpdate('cascade')->onDelete('cascade');
                  
            $table->foreign('domain_provider_id')
                  ->references('id')->on('domain_providers')
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
        Schema::dropIfExists('purchased_domains');
    }
}
