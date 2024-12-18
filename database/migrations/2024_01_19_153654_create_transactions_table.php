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
        Schema::create('transaction', function (Blueprint $table) {
            $table->unsignedInteger('trans_id')->autoIncrement();
            $table->unsignedInteger('transfer_id')->nullable();
            $table->unsignedInteger('category_id')->nullable();
            $table->unsignedInteger('account_id');
            $table->date('trans_date');
            $table->tinyInteger('trans_type');
            $table->decimal('trans_amount', 15, 2);
            $table->string('trans_remark', 250)->nullable();
            $table->unsignedInteger('updated_by');
            $table->dateTime('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction');
    }
}
