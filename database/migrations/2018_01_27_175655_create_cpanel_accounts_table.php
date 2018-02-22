<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCpanelAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cpanel_accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hosting_contract_id')->unsigned();
            $table->string('domain_name')->unique()->nullable();
            $table->string('user')->unique()->nullable();
            $table->string('password')->nullable();
            $table->char('public_ip', 16)->nullable();
            $table->timestamps();

            $table->foreign('hosting_contract_id')
                  ->references('id')->on('hosting_contracts')
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
        Schema::dropIfExists('cpanel_accounts');
    }
}
