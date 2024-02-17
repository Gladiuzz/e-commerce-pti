<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('transaction_id');
            $table->string('no_receipt', 11);
            $table->string('name');
            $table->string('phone_number', 20);
            $table->string('email');
            $table->text('full_address');
            $table->string('city');
            $table->string('province');
            $table->string('courier_type');
            $table->string('courier_status');
            $table->string('zip_code');
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
        Schema::dropIfExists('transaction_detail');
    }
}
