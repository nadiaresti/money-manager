<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_attachment', function (Blueprint $table) {
            $table->unsignedInteger('attachment_id')->autoIncrement();
            $table->unsignedInteger('trans_id');
            $table->string('attachment_name', 250);

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
        Schema::dropIfExists('transaction_attachment');
    }
}
