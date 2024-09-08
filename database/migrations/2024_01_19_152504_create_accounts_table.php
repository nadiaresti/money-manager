<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account', function (Blueprint $table) {
            $table->unsignedInteger('account_id')->autoIncrement();
            $table->unsignedInteger('group_id');
            $table->string('account_name', 50);
            $table->string('account_description', 250)->nullable();
            $table->double('account_balance', 20, 2)->default(0.00);
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
        Schema::dropIfExists('accounts');
    }
}
