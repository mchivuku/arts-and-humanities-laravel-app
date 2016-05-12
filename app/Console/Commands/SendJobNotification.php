<?php
/**
 * Created by PhpStorm.
 * User: mchivuku
 * Date: 5/9/16
 * Time: 1:48 PM
 */
namespace ArtsAndHumanities\Console\Commands;

use Illuminate\Console\Command;

class SendJobNotification extends Command
{
    protected $name = 'email:notify';
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {

        $jobs= \DB::table('job_log')->select(array("*"))
            ->whereRaw('DATE(`timestamp`) = CURDATE() and event like "Job%"')->get();

        // groups jobs - by name - to capture stats
        $result = [];
        foreach ($jobs as $job) {
            $name = $job->name;
            $result[$name][] = $job;
        }

        $data = array_map(function($job){
            $details = "";
            $status = "";$name="";

            foreach($job as $v){

                $name = $v->name;
                switch($v->event){
                    case "Job start":
                        $details.=" Job started: ". $v->timestamp ." <br/>" ;
                        break;

                    case "Job finish":
                        $details.=" Job finished: ". $v->timestamp ." <br/>" ;
                        $status = "Success";
                        break;

                    case "Job Failed":
                        $details.=" Job failed: ". $v->timestamp ." <br/>".$v->message ;
                        $status = "Failed";
                        break;

                }

            }

            return ["name"=>$name,"status"=>$status,"details"=>$details];
        },$result);


        // Change it to Jay - when required .. TODO
        \Mail::send('emails.notify', ["jobs"=>$data],
            function ($message){
                $message->subject('Job Notification - '. date("F j, Y"))
                    ->to('mchivuku@iu.edu');

            });


    }

}