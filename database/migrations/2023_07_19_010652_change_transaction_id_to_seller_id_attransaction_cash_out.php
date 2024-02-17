<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTransactionIdToSellerIdAttransactionCashOut extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaction_cash_out', function (Blueprint $table) {
            $table->renameColumn('transaction_id', 'seller_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaction_cash_out', function (Blueprint $table) {
            $table->renameColumn('seller_id', 'transaction_id');
        });
    }
}
