<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_schedule', function (Blueprint $table) {
            $table->increments('id');

            $table->string('event_id');
            $table->timestamp('start_date_time')->nullable();
            $table->timestamp('end_date_time')->nullable();

            $table->timestamp('updated_at');
        });

        DB::statement('ALTER TABLE `event_schedule` MODIFY COLUMN `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        DB::statement('ALTER TABLE `event` DROP COLUMN start_date_time');
        DB::statement('ALTER TABLE `event` DROP COLUMN end_date_time');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('event_schedule');
    }
}
