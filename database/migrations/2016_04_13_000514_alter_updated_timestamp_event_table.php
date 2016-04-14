<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUpdatedTimestampEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //ALTER TABLE whatevertable
        //CHANGE whatevercolumn
          //  whatevercolumn TIMESTAMP NOT NULL
            //               DEFAULT CURRENT_TIMESTAMP
              //
        //             ON UPDATE CURRENT_TIMESTAMP;ALTER TABLE `event` MODIFY COLUMN created_at TIMESTAMP DEFAULT 0;

    //    DB::statement('ALTER TABLE `event` MODIFY COLUMN created_at TIMESTAMP DEFAULT \'0000-00-00 00:00:00\'');

        DB::statement('ALTER TABLE `event` MODIFY COLUMN `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
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
