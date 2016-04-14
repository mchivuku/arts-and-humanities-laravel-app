<?php
/**
 * Created by PhpStorm.
 * User: mchivuku
 * Date: 4/12/16
 * Time: 1:13 PM
 */

function l($val){
    return Clockwork::info($val);
}

function start($name, $description){
    return Clockwork::startEvent($name,$description);

}

function stop($name, $description){
    return Clockwork::endEvent($name,$description);
}
