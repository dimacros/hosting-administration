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
            $table->integer('domain_provider_id')->unsigned();
            $table->string('domain_name')->unique();
            $table->text('description');
            $table->integer('contract_duration_in_months');
            $table->decimal('total_price_in_dollars');
            $table->date('start_date');
            $table->date('due_date');
            $table->integer('user_id')->unsigned();
            $table->timestamps();
            $table->foreign('domain_provider_id')
                  ->references('id')->on('domain_providers')
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