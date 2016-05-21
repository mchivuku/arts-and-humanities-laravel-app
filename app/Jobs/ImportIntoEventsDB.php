<?php
/**
 * Created by PhpStorm.
 * User: mchivuku
 * Date: 4/11/16
 * Time: 4:30 PM
 */

namespace ArtsAndHumanities\Jobs;

class ImportIntoEventsDB extends Job
{

    protected $job_user = 'jobuser';

    public function __construct()
    {
        parent::__construct('ImportIntoEventsDB');
    }

    function importIntoEvent($data)
    {


        $insert_array = [];

        foreach ($data['event'] as $row) {

            $e = [];
            //row, event, key, dbkey
            $this->add_isset($row, $e, 'calendar-id', 'calendar_id');
            $this->add_isset($row, $e, 'event-url', 'event_url');
            $this->add_isset($row, $e, 'summary', 'summary');
            $this->add_isset($row, $e, 'description', 'description');
            $this->add_isset($row, $e, 'location', 'location');
            $this->add_isset($row, $e, 'featured', 'featured');
            $this->add_isset($row, $e, 'access-class', 'access_class');
            $this->add_isset($row, $e, 'image-url-small', 'image_url_small');
            $this->add_isset($row, $e, 'image-url-large', 'image_url_large');
            $this->add_isset($row, $e, 'created-date', 'event_created_date', 'datetime');
            $this->add_isset($row, $e, 'last-modification-date','event_last_modification_date', 'datetime');
            $this->add_isset($row, $e, 'cost', 'cost');
            $this->add_isset($row, $e, 'contact-email', 'contact_email');
            $this->add_isset($row, $e, 'longitude', 'longitude', "string", null);
            $this->add_isset($row, $e, 'latitude', 'latitude', "string", null);
            $this->add_isset($row, $e, 'iu-building-code', 'iu_building_code');
            $this->add_isset($row, $e, 'more-contact-info', 'more_contact_info');
            $this->add_isset($row, $e, 'other-info', 'other_info');
            $this->add_isset($row, $e, 'unique-id', 'unique_id');
            $this->add_isset($row, $e, 'url', 'url');
            $e['update_user'] = $this->job_user;

            $insert_array[] = $e;

        }


        self::insertOrUpdate('event', $insert_array);

    }

    /*
     * Convert xml to array
     */

    function importIntoEventAttachment($data)
    {

        try {
            $attachments = $this->group_by('attachments', $data['event']);
            $insert_array = "";
            foreach ($attachments as $k => $v) {
                foreach ($v as $a) {
                    $i['event_id'] = $k;
                    $i['value_type'] = $a['value-type'];
                    $i['value'] = $a['value'];
                    $i['encoding'] = $a['encoding'];
                    $i['mime_type'] = $a['mime-type'];
                    $i['update_user'] = $this->job_user;

                    $insert_array[] = $i;
                }
            }

            \DB::table('event_attachment')->truncate();
            \DB::table('event_attachment')->insert($insert_array);

        } catch (\Exception $ex) {
            var_dump($ex);
        }

    }

    protected function getStartEndDate(){
        $start_date = date('Y-m-d');
        $end_date =  date('Y-m-d', strtotime("+3 months", strtotime($start_date)));
        return "&startDate=" . $start_date . "&endDate=" . $end_date;


    }

    //row, event, key, dbkey

    /**
     * Default function that runs when job starts
     */
    protected function run()
    {
        // TODO: Implement run() method.



        /*
         * TODO::Check for dates and append query string
         */
        $url = 'https://uisapp2.iu.edu/ccl-prd/Xml.do?pubCalId=GRP21140';
        $url .= $this->getStartEndDate();

        $data = $this->xml($url);


        /*
         * Import Into Event
         */
         $this->importIntoEvent($data);

        /*
         * Import Into Event contacts
        */


         $this->importIntoEventContact($data);

        /*
        * Import Into Event attachments - not using event attachments
        */
        // $this->importIntoEventAttachment($data);

        /*
         * Import Into Event schedule
         */
         $this->importIntoEventSchedule($data);

        /*
        * Import Into Event categories
        */
        $this->importIntoEventCategories($data);

    }


    function getRemoteFileContents($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        $data = curl_exec($curl);

        return $data;
    }

    private function xml($string)
    {

        libxml_use_internal_errors(true);

        if ($string) {
            $data = $this->getRemoteFileContents($string);
            $xml = @simplexml_load_string($data, 'SimpleXMLElement', LIBXML_COMPACT | LIBXML_PARSEHUGE);

            if ($xml === false) {
                echo "Failed loading XML\n";
                foreach(libxml_get_errors() as $error) {
                    echo "\t", $error->message;
                }
            }else{
                return json_decode(json_encode((array)$xml), 1);

            }

        }
        return array();
    }

    /*
     * Function imports data into event table.
     */

    function importIntoEventContact($data)
    {

        $insert_array = "";
        $total = 0;

        $contacts = $this->group_by('contacts', $data['event']);


       \DB::table('event_contact')->whereIn('event_id',collect($contacts)->keys()->all())->delete();

        foreach ($contacts as $k => $v) {
            foreach ($v as $c) {
                $i['event_id'] = $k;
                $i['contact_info'] = $c;
                $i['update_user'] = $this->job_user;

                $insert_array[] = $i;

            }
        }

        \DB::table('event_contact')->insert($insert_array);


    }

    private function group_by($key, $events)
    {

        $grp_array = "";

        foreach ($events as $event) {
            $id = $event['unique-id'];

            if (array_key_exists($key, $event)) {
                foreach ($event[$key] as $element) {

                    if (isset($grp_array[$id])) {
                        if (!in_array($element, $grp_array[$id]))
                            $grp_array[$id][] = $element;
                    } else {
                        $grp_array[$id] = array($element);
                    }
                }

            }
        }

        return $grp_array;

    }

    function importIntoEventSchedule($data)
    {
        $schedules_array = "";
        foreach ($data['event'] as $event) {
            $id = $event['unique-id'];
            $schedule = "";

            $this->add_isset($event, $schedule, 'start-date-time', 'start_date_time', 'datetime');
            $this->add_isset($event, $schedule, 'end-date-time', 'end_date_time', 'datetime');

            if (isset($schedules_array[$id])) {
                $schedules_array[$id][] = $schedule;
            } else {
                $schedules_array[$id] = array($schedule);
            }
        }

        \DB::table('event_schedule')->whereIn('event_id',collect($schedules_array)->keys()->all())->delete();

        $insert_array = "";
        foreach ($schedules_array as $k => $v) {
            foreach ($v as $x) {
                $i['event_id'] = $k;
                $i['start_date_time'] = $x['start_date_time'];
                $i['end_date_time'] = $x['end_date_time'];
                $i['update_user'] = $this->job_user;

                $insert_array[] = $i;
            }
        }

        \DB::table('event_schedule')->insert($insert_array);

    }

    private function add_isset($row, &$e, $key, $dbkey, $format = 'string', $default = "")
    {

        if (isset($row[$key])) {
            if ($format == 'datetime') {
                $parts = explode('-', $row[$key]);
                $datestring = isset($row[$key]) ?
                    date('Y-m-d',
                        strtotime($parts[1] . '-' . $parts[0] . '-' . $parts[2])) :
                    FALSE;

                $timestring = isset($row[$key])
                    ? date('g:i A', strtotime($parts[1] . '-' . $parts[0] . '-' . $parts[2])) : FALSE;

                $e[$dbkey] = date('Y-m-d G:i:s', strtotime($datestring . " " . $timestring));
            } else
                $e[$dbkey] = $row[$key];

        } else
            $e[$dbkey] = $default;
    }

    function importIntoEventCategories($data)
    {

        $insert_array = "";

        $categories = $this->group_by('categories', $data['event']);

        if(!isset($categories) && !count($categories)>0)return;



        \DB::table('event_category')->whereIn('event_id',collect($categories)->keys()->all())->delete();
        foreach ($categories as $k => $v) {
            foreach ($v as $cat) {

                if(is_array($cat)){
                    foreach ($cat as $c) {

                        $i['event_id'] = $k;//primary key
                        $i['category'] = $c;// primary key
                        $i['update_user'] = $this->job_user;

                        $insert_array[] = $i;
                    }
                }else{
                    $i['event_id'] = $k;//primary key
                    $i['category'] = $cat;// primary key
                    $i['update_user'] = $this->job_user;

                    $insert_array[] = $i;
                }


            }
        }

        \DB::table('event_category')->insert($insert_array);
    }

}