<?php
/**
 * Created by PhpStorm.
 * User: mchivuku
 * Date: 4/14/16
 * Time: 10:25 AM
 */

namespace ArtsAndHumanities\Services;

class HtmlMacros extends \Collective\Html\HtmlBuilder {

    public function __construct( $url,  $view)
    {
        parent::__construct($url, $view);
    }

    public function dashboardPanel($title,$links){

        $html = "<div class=\"panel \">";
        $html.="<h2>$title</h2>";

        foreach($links as $link)
            $html.="<p>".$this->link($link['url'],$link['label']).'</p>';

        $html .= "</div>";
        return $html;

    }


}