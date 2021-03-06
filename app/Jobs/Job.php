<?php

namespace ArtsAndHumanities\Jobs;

use Illuminate\Bus\Queueable;
use Mockery\CountValidator\Exception;

abstract class Job
{

    const JOB_START = "Job start";
    const JOB_FINISH = "Job finish";
    const JOB_FAIL = "Job Failed";
    const WIPE_TABLE = "Table wipe";

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

            // Log job started.
            //self::log($this->_jobName,self::JOB_START) ;



             $this->run();

            /*
            * Job ended
            */

           // self::log($this->_jobName,self::JOB_FINISH) ;



        }catch(\Exception $ex){

            var_dump($ex->getMessage());
            /*
             * Job Failed
             */
            //self::log($this->_jobName,self::JOB_FAIL,$ex->getMessage(),$ex);
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


        try{
            return  \DB::statement( $sql );
        }catch(\Exception $ex){
            var_dump($ex->getMessage());
        }


    }



    static function log($job_name, $event, $message=""){

        if(isset($message) && $message!=""){

            $info = ['name'=>$job_name,
                'event'=>$event,
                'message'=>$message];

        }


        $info = ['name'=>$job_name,'event'=>$event,'message'=>$message];

        \DB::table('job_log')->insert(
            $info
        );

        return;

    }

}
