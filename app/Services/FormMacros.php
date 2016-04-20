<?php
/**
 * Created by PhpStorm.
 * User: mchivuku
 * Date: 4/14/16
 * Time: 10:25 AM
 */

namespace ArtsAndHumanities\Services;

use Collective\Html\FormBuilder;

class FormMacros extends FormBuilder {

    public function __construct( $html,  $url,  $view, $csrfToken)
    {
        parent::__construct($html, $url, $view, $csrfToken);
    }


    public function formGroup($label,$control){

        $method="";
        $parameters=[];

        $html = "<div class=\"form-item\"><div class=\"form-item-label\">";
        $html.= $label;
        $html.="</div>";
        $html.="<div class=\"form-item-input\">";
        $html.=$control;
        $html.="</div></div>";

        return $html;

    }

    /*public function label($name, $value = null, $options = [])
    {
        $html = "<div class=\"form-item-label\">";
        $html .= parent::label($name, $value, $options);
        $html.="</div>";

        return $this->toHtmlString($html);
    }*/

}