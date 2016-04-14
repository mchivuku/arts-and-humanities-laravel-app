<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableAddUsername extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement('ALTER TABLE `event` ADD COLUMN `update_user` VARCHAR(50)');
        \DB::statement('ALTER TABLE `event_attachment` ADD COLUMN `update_user` VARCHAR(50)');
        \DB::statement('ALTER TABLE `event_category` ADD COLUMN `update_user` VARCHAR(50)');
        \DB::statement('ALTER TABLE `event_contact` ADD COLUMN `update_user` VARCHAR(50)');
        \DB::statement('ALTER TABLE `event_recommendation` ADD COLUMN `update_user` VARCHAR(50)');
        \DB::statement('ALTER TABLE `event_schedule` ADD COLUMN `update_user` VARCHAR(50)');
        \DB::statement('ALTER TABLE `event_type` ADD COLUMN `update_user` VARCHAR(50)');
        \DB::statement('ALTER TABLE `type` ADD COLUMN `update_user` VARCHAR(50)');
        \DB::statement('ALTER TABLE `venue` ADD COLUMN `update_user` VARCHAR(50)');


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
