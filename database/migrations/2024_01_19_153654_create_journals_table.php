<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJournalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journal', function (Blueprint $table) {
            $table->unsignedInteger('journal_id')->autoIncrement();
            $table->unsignedInteger('period_id');
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('account_id');
            $table->date('journal_date');
            $table->tinyInteger('journal_type');
            $table->double('journal_amount', 15, 2);
            $table->string('journal_description', 250)->nullable();
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
        Schema::dropIfExists('journals');
    }
}
