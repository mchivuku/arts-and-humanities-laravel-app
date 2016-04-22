<?php
/**
 * Created by PhpStorm.
 * User: mchivuku
 * Date: 4/21/16
 * Time: 3:30 PM
 */

namespace ArtsAndHumanities\Models;

use Corcel\Post as Corcel;

class ViewPointsPost extends Corcel
{
    protected $connection = 'wordpress';
    protected $table='posts';
}