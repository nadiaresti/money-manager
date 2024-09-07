<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category', function (Blueprint $table) {
            $table->id('category_id')->unsigned();
            $table->string('category_name', 25);
            $table->tinyInteger('category_type');
            $table->unsignedInteger('parent_id')->nullable();
            $table->unsignedInteger('updated_by');
            $table->dateTime('updated_at');

            $table->primary('category_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category');
    }
}
