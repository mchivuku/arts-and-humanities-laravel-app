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

    public function renderBeginSection($title="",$bgColor = "bg-none",$first=false,$text=true){
        if($first)
           $html = "<section class=\"$bgColor section\" id=\"content\">";
        else
            $html = "<section class=\"$bgColor section\">";

        $html.="<div class='row'><div class=\"layout\">";

        if($title!="")
            $html.="<h2 class=\"section-title\">$title</h2>";

        $html.="<div class=\"full-width\">";

        if($text)
            $html.="<div class='text'>";

        return $html;


    }


    public function renderEndSection($text=true){
        $html="";
        if($text)
            $html = "</div>";

        $html.="</div></div></div></section>";

        return $html;

    }


}
