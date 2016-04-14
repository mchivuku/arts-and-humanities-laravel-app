<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventAttachementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_attachment', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("event_id");
            $table->string("value_type");
            $table->binary("value");
            $table->string("encoding",100);
            $table->string("mime_type",100);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('event_attachment');
    }
}
