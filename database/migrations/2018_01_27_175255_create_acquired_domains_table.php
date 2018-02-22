<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcquiredDomainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acquired_domains', function (Blueprint $table) {
            $table->increments('id');
            $table->string('domain_name')->unique();
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'expired']);
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
        Schema::dropIfExists('acquired_domains');
    }
}
