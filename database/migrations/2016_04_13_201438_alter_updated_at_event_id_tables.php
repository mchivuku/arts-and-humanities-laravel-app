<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUpdatedAtEventIdTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      /*  DB::statement('ALTER TABLE `event_category` MODIFY COLUMN `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
         DB::statement('ALTER TABLE `event_category` MODIFY COLUMN `event_id` VARCHAR(255)');


         DB::statement('ALTER TABLE `event_recommendation` ADD COLUMN `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        DB::statement('ALTER TABLE `event_recommendation` MODIFY COLUMN `event_id` VARCHAR(255)');

         DB::statement('ALTER TABLE `event_type` ADD COLUMN `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        DB::statement('ALTER TABLE `event_type` MODIFY COLUMN `event_id` VARCHAR(255)');

        DB::statement('ALTER TABLE `type` MODIFY COLUMN `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        DB::statement('ALTER TABLE `venue` ADD COLUMN `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');*/


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
