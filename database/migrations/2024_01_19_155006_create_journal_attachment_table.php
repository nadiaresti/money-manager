<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJournalAttachmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journal_attachment', function (Blueprint $table) {
            $table->unsignedInteger('attachment_id')->autoIncrement();
            $table->unsignedInteger('journal_id');
            $table->string('attachment_name', 250);

            $table->foreign('journal_id')->references('journal_id')->on('journal')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('journal_attachment');
    }
}
