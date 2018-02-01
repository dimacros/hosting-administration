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
            $table->integer('hosting_plan_contracted_id')->unsigned();
            $table->date('start_date');
            $table->date('due_date');
            $table->char('public_ip',15)->unique();
            $table->string('cpanel_user')->unique();
            $table->string('cpanel_password');
            $table->string('domain_name')->unique();
            $table->enum('status', ['activo', 'vencido', 'cancelado']);
            $table->integer('user_id')->unsigned();
            $table->timestamps();
            $table->foreign('customer_id')
                  ->references('id')->on('customers')
                  ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('hosting_plan_contracted_id')
                  ->references('id')->on('hosting_plans_contracted')
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
