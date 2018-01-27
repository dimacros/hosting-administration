<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHostingPlansContractedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hosting_plans_contracted', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hosting_plan_id')->unsigned();
            $table->boolean('current_hosting_plan');
            $table->string('title');
            $table->text('description');
            $table->integer('contract_duration_in_months');
            $table->decimal('total_price');
            $table->timestamps();
            $table->foreign('hosting_plan_id')
                  ->references('id')->on('hosting_plans')
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
       Schema::dropIfExists('hosting_plans_contracted');
    }
}
