<?php
/**
 * Created by PhpStorm.
 * User: mchivuku
 * Date: 4/15/16
 * Time: 2:38 PM
 */
namespace ArtsAndHumanities\Models\ViewModels;

/** Event view model - returned for the results on the evnt lookup page */
class LookupEventVM{

    public $id;
    public $image_url_small;
    public $summary;
    public $types;
    public $venue;
    public $schedules;

}