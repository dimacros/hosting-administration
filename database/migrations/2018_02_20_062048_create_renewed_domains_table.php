<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRenewedDomainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('renewed_domains', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('purchased_domain_id')->unsigned();
            $table->date('start_date');
            $table->date('finish_date');
            $table->decimal('total_price_in_dollars');
            $table->integer('user_id')->unsigned();
            $table->timestamps();

            $table->foreign('purchased_domain_id')
                  ->references('id')->on('purchased_domains')
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
        Schema::dropIfExists('renewed_domains');
    }
}
