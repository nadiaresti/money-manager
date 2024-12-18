<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_transfer', function (Blueprint $table) {
            $table->unsignedInteger('transfer_id')->autoIncrement();
            $table->unsignedInteger('trans_id');
            $table->unsignedInteger('destination_id');
            $table->decimal('admin_fee', 10, 2);

            $table->foreign('trans_id')->references('trans_id')->on('transaction')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_transfers');
    }
}
