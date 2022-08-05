<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('code', 100)->nullable();
            $table->string('vehicle_no', 100)->nullable();
            $table->datetime('check_in')->nullable();
            $table->datetime('check_out')->nullable();
            $table->integer('hours')->default(0);
            $table->integer('price')->default(0);
            $table->integer('total')->default(0);
            $table->integer('user_created')->default(0);
            $table->integer('user_updated')->default(0);
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
        Schema::dropIfExists('transactions');
    }
}
