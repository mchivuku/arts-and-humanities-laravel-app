<?php

namespace ArtsAndHumanities\Jobs;

use Illuminate\Bus\Queueable;

abstract class Job
{
    /*
    |--------------------------------------------------------------------------
    | Queueable Jobs
    |--------------------------------------------------------------------------
    |
    | This job base class provides a central location to place any logic that
    | is shared across all of your jobs. The trait included with the class
    | provides access to the "onQueue" and "delay" queue helper methods.
    |
    */


    use Queueable;



    public function getName(){
        return $this->_jobName;
    }

    public function __construct($jobName)
    {
        $this->_jobName = $jobName;
    }

    /**
     * Execute method calls run method to perform logging for the job
     */
    public function execute(){

        try{

            /*
             * Job started
             */
            \Log::info(sprintf("%s: %s", $this->_jobName,JobEvents::JOB_START));

            $this->run();

            /*
            * Job ended
            */
            \Log::info(sprintf("%s: %s", $this->_jobName,JobEvents::JOB_FINISH));


        }catch(\Exception $ex){

            /*
             * Job Failed
             */
            \Log::error(sprintf("%s: %s", $this->_jobName,JobEvents::JOB_FAIL));

        }
    }


    protected  abstract function run();

    /*
     * Helper function
     */

    protected static function insertOrUpdate($table,array $rows){
        $first = reset($rows);

        /**
         * Build columns
         */
        $columns = implode( ',',
            array_map( function( $value ) { return "$value"; } ,
                array_keys($first) )
        );


        /**
         * Build value list
         */
        $values = implode( ',', array_map( function( $row ) {
                return '('.implode( ',',
                    array_map( function( $value )
                    { return '"'.str_replace('"', '""', $value).'"'; } , $row )
                ).')';
            } , $rows )
        );

        /**
         * Update query
         */
        $updates = implode( ',',
            array_map( function( $value ) {
                return "$value = VALUES($value)"; } ,
                array_keys($first) )
        );

        //Interesting
        $sql = "INSERT INTO {$table}({$columns}) VALUES {$values} ON DUPLICATE KEY UPDATE {$updates}";


        return \DB::statement( $sql );
    }
}
