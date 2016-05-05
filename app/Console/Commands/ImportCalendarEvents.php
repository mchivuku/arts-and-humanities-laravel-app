<?php
/**
 * Created by PhpStorm.
 * User: mchivuku
 * Date: 5/4/16
 * Time: 3:51 PM
 */

namespace ArtsAndHumanities\Console\Commands;

use ArtsAndHumanities\Jobs\ImportIntoEventsDB;
use Illuminate\Console\Command;

class ImportCalendarEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:calendar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'jobs runs to import calendar events';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $job = new ImportIntoEventsDB();

        $job->execute();

        echo 'completed job';
        echo PHP_EOL;
    }
}
