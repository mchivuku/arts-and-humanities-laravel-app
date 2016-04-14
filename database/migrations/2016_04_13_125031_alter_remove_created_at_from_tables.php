<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterRemoveCreatedAtFromTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //alter table TableName
       // drop column Column1, Column2
        DB::statement('ALTER TABLE `event` DROP COLUMN created_at');
        DB::statement('ALTER TABLE `event_attachment` DROP COLUMN created_at');
        DB::statement('ALTER TABLE `event_category` DROP COLUMN created_at');
        DB::statement('ALTER TABLE `event_contact` DROP COLUMN created_at');
        DB::statement('ALTER TABLE `type` DROP COLUMN created_at');
        DB::statement('ALTER TABLE `venue` DROP COLUMN created_at');

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
