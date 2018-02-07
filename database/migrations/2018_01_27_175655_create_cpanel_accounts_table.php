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
            $table->string('domain_name')->unique();
            $table->string('user')->unique();
            $table->string('password')->nullable();
            $table->char('public_ip', 16)->nullable();
            $table->timestamps();
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
