<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeriodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('period', function (Blueprint $table) {
            $table->id('period_id')->unsigned();
            $table->string('period_name', 6);
            $table->tinyInteger('period_status')->unsigned()->comment('0=close; 1=open;');
            $table->unsignedInteger('updated_by');
            $table->dateTime('updated_at');

            $table->primary('period_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('period');
    }
}
