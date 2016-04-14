<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event', function (Blueprint $table) {
          //  $table->increments('id');
            $table->string("calendar_id",100);
            $table->string("event_url");

            $table->integer("event_id");
            $table->string("unique_id")->primary();
            $table->string("summary");
            $table->string("access_class",200);
            $table->string("featured",50);


            $table->longText("description");
            $table->text("short_description");

            $table->string("location");
            $table->string("cost",200);
            $table->string("contact_email");

            //Images
            $table->string("image_url_small");
            $table->string("image_url_large");
            $table->string("website_image_url_small");
            $table->string("website_image_url_large");
            $table->string("website_featured_image_url");

            $table->integer("venue_id");

            $table->char("student_pick",1);//0,1
            $table->char("faculty_only",1);//0,1
            $table->char("faculty_enrichment_event",1); //0,1

            $table->float("latitude");
            $table->float("longitude");

            $table->timestamp("event_created_date");
            $table->timestamp("event_last_modification_date");
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
        Schema::drop('events');
    }
}
