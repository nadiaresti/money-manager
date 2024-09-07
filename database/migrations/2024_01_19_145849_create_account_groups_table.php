<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_group', function (Blueprint $table) {
            $table->id('group_id')->unsigned();
            $table->string('group_code', 10)->unique();
            $table->string('group_name', 25);
            $table->unsignedInteger('updated_by');
            $table->dateTime('updated_at');

            $table->primary('group_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_group');
    }
}
